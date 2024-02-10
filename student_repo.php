<?php
session_start();

// Check if the page is loaded with a refresh request
$tableData=[];

$_SESSION['tableData'] = $tableData;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_GET['refresh'])) {
    unset($_SESSION['category']);
    unset($_SESSION['year']);
    unset($_SESSION['gender']);
}

require_once('config.php'); 

// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit();
}

// Initialize filter variables
$category = isset($_SESSION['category']) ? $_SESSION['category'] : "";
$year = isset($_SESSION['year']) ? $_SESSION['year'] : "";
$gender = isset($_SESSION['gender']) ? $_SESSION['gender'] : "";

// Database connection parameters
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'login';

// Establishing a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search variable
$search = "";

// Check if search query is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
  // Convert entered name to uppercase
  $search = strtoupper($_POST['search']);
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = isset($_POST["category"]) ? $conn->real_escape_string($_POST["category"]) : "";
    $year = isset($_POST["year"]) ? $conn->real_escape_string($_POST["year"]) : "";
    $gender = isset($_POST["gender"]) ? $conn->real_escape_string($_POST["gender"]) : "";

    // Store filter values in session variables
    $_SESSION['category'] = $category;
    $_SESSION['year'] = $year;
    $_SESSION['gender'] = $gender;
}

// Constructing the SQL query based on filters and search
$query = "SELECT username, gender, address, department, year, dob, category, contact 
          FROM users 
          WHERE 1"; // Start with a WHERE clause that will always be true

// Adding conditions for filters
if (!empty($category)) {
    $query .= " AND category = '$category'";
}
if (!empty($year)) {
    $query .= " AND year = '$year'";
}
if (!empty($gender)) {
    $query .= " AND gender = '$gender'";
}
// Add search condition
if (!empty($search)) {
    $query .= " AND UPPER(username) LIKE '%$search%'";
}

// Modify the ORDER BY clause to order by year in the specified custom order
$query .= " ORDER BY 
            CASE 
                WHEN year = 'FE' THEN 1
                WHEN year = 'SE' THEN 2
                WHEN year = 'TE' THEN 3
                WHEN year = 'BE' THEN 4
                ELSE 5
            END";

// Execute the query
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableData[] = $row;
    }
    $result->free(); // Free result set
}

if (isset($_POST["delete_submit"])) {
  $deleteName = mysqli_real_escape_string($conn, $_POST["delete_name"]);

  // Query to delete the record based on the provided name
  $deleteSql = "DELETE FROM users WHERE username = '$deleteName'";
  $deleteResult = mysqli_query($conn, $deleteSql);

  if ($deleteResult) {
      echo '<div id="successAlert1" class="alert alert-success" role="alert">
              Record of ' . $deleteName . ' has been deleted successfully.
            </div>';
            header("Location:student_repo.php".$_SERVER['PHP_SELF']); // Redirect to the same page

  
  } else {
      echo "Error deleting record: " . mysqli_error($conn);
  }
}
// Close database connection
$conn->close();
?>














<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
          <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Student Data Filter</title>
<style>
  body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 0;
}

.container {
  width: auto;
  height: 13rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}



.main_form {
  margin-top: 29vh;
  background-color: white;
  width: 80%;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
  display: block;
  font-size: 2em;
  margin-block-start: 0.67em;
  margin-block-end: 0.67em;
  margin-inline-start: 0px;
  margin-inline-end: 0px;
  font-weight: bold;
}

input[type="text"],
select,
input[type="submit"] {
  margin: 5px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type="text"] {
  flex: 1;
}

select {
  flex: 1;
  appearance: none;
  -webkit-appearance: none;
  -moz-appearance: none;
  background-image: url('data:image/svg+xml;utf8,<svg fill="%23444444" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.406 10.594L12 15.188l4.594-4.594L18 12l-6 6-6-6 1.406-1.406zM6 6h12v2H6zm0 6h12v2H6zm0 6h12v2H6z"/></svg>');
  background-repeat: no-repeat;
  background-position: right 10px center;
  background-size: 18px;
}

input[type="submit"] {
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
  background-color: #0056b3;
}

.data-table {
  margin-top: 19vh; /* Keep this */
  background-color: white;
  width: 80%;
  margin: 19vh auto 20px; /* Adjusted margin to include top margin */
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}


.data-table th,
.data-table td {
  padding: 10px;
}

.data-table th {
  background-color: #003355;
  color: white;
}

.data-table tbody tr:nth-child(even) {
  background-color: #f2f2f2;
}

.pdf-link-container {
  display: inline-block; /* Ensure the container occupies only the necessary space */
  margin-top: 10px;
  margin-left: 10px; /* Adjust margin to create space between buttons */
}

.pdf-link {
  padding: 8px 12px;
  background-color: #003355;
  border-radius: 14px;
  color: white;
  text-decoration: none;
}

.pdf-link:hover {
  background-color: #005d91;
}


  /* Define the default styles for .navbar and .box1 */
  .navbar {
            width: 100%; /* Adjust this width as needed */
        }


</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark " style="background-color:#042d41;      position: fixed;
    top: 0;
    z-index: 999;color:white;">
    <a class="navbar-brand" style="margin-left: 65px;" href="#">Nss Login System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="welcome.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="#" >Events</a>
            </li>
        
            <li class="nav-item active">
                <a class="nav-link" href="Logout.php"> Logout </a>
            </li>
        </ul>
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png">
                        <?php echo "Welcome " . $_SESSION['username'] ?></a>
                </li>
            </ul>
        </div>
    </div>
</nav>



<div class="container">
  
  <form action="student_repo.php" method="post" class="main_form">
    <input type="text" name="search" placeholder="Search...">
    <select name="category" id="category">
      <option value=""  selected disabled   >Select Category</option>
      <option value="Open">Open</option>
      <option value="Scheduled Castes (SC)">Scheduled Castes (SC)</option>
      <option value="Scheduled Tribe (ST)">Scheduled Tribe (ST)</option>
      <option value="Vimukta Jati (VJ) / De-Notified Tribes (DT) (NT-A)">Vimukta Jati (VJ) / De-Notified Tribes (DT) (NT-A)</option>
      <option value="Nomadic Tribes 1 (NT-B)">Nomadic Tribes 1 (NT-B)</option>
      <option value="Nomadic Tribes 2 (NT-C)">Nomadic Tribes 2 (NT-C)</option>
      <option value="Nomadic Tribes 3 (NT-D)">Nomadic Tribes 3 (NT-D)</option>
      <option value="Other Backward Classes (OBC)">Other Backward Classes (OBC)</option>
      <option value="Socially and Educationally Backward Classes (SEBC)">Socially and Educationally Backward Classes (SEBC)</option>
    </select>
    <select name="year" id="year">
      <option value=""   selected disabled    >Select Year</option>
      <option value="FE">FE</option>
      <option value="SE">SE</option>
      <option value="TE">TE</option>
      <option value="BE">BE</option>
    </select>
    <select name="gender" id="gender">
      <option value="" selected disabled      >Select Gender</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
      <option value="Other">Other</option>
    </select>
    <input type="submit" value="Filter" class="Buttons">
    </form>
    <div class="pdf-link-container">

    <form method="post" action="gdata.php"> 
    <input type="hidden" name="data" value="<?php echo urlencode(json_encode($tableData)); ?>">
    <button type="submit" class="pdf-link">Generate PDF</button>
  </form>
  </div>


</div>
<!-- Display table -->
<?php if (!empty($tableData)): ?>
  <table class="data-table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Gender</th>
        <th>Address</th>
        <th>Department</th>
        <th>Year</th>
        <th>DOB</th>
        <th>Category</th>
        <th>Contact</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($tableData as $row): ?>
        <tr>
          <td><?php echo $row['username']; ?></td>
          <td><?php echo $row['gender']; ?></td>
          <td><?php echo $row['address']; ?></td>
          <td><?php echo $row['department']; ?></td>
          <td><?php echo $row['year']; ?></td>
          <td><?php echo $row['dob']; ?></td>
          <td><?php echo $row['category']; ?></td>
          <td><?php echo $row['contact']; ?></td>
          <td>
            <form action=''method='post'>
              <input type='hidden' name='delete_name' value='<?php echo $row['username']; ?>'>
              <input type='submit' name='delete_submit' value='Delete' style='background-color: red; color: white;'>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

</body>
</html>
