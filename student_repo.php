<?php
session_start();
require_once('config.php'); 
require('fpdf/fpdf.php');


// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit();
}


$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'login';


// Check if the form was submitted and userInput is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['userInput'])) {
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve and sanitize the scrolling text from the form
    $newText = $conn->real_escape_string($_POST["userInput"]);

    // Update the database with new text
    $sql = "UPDATE content_text SET scrolling_text='$newText'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = true; // Set a session variable for success message
        $conn->close();
        header("Location: student_repo.php");
        exit();
    } else {
        echo "Error updating scrolling text: " . $conn->error;
    }

    $conn->close();
}

if($_SERVER["REQUEST_METHOD"]=="POST"&& !empty($_POST['news_card'])){
    $conn=new mysqli($servername,$username,$password,$dbname);
    
    if($conn->connect_error){
        die("Connection Failed !! ".$conn->connect_error);
    }
    $newsdata=$conn->real_escape_string($_POST['news_card']);
    
    $sql="UPDATE content_text SET news_card='$newsdata'";

    if($conn->query($sql)== TRUE){
        $_SESSION['success']= TRUE;
        $conn->close();
        header('Location: student_repo.php');
        exit();
    }
    else{
        echo "Error Updating the news Data ".$conn->error;
    }
}



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


    $news = "";
    $notification = "";
    
    if(isset($_POST['news_card'])) {
        $newsText = $_POST['news_card'];
        $sql = "UPDATE content_text SET news='$newsText'";
        $conn->query($sql);
    
        $_SESSION['news'] = $newsText; // Store in session
    }
    
    if(isset($_POST['notification'])) {
        $notificationText = $_POST['notification'];
        $sql = "UPDATE content_text SET notification='$notificationText'";
        $conn->query($sql);
    
        $_SESSION['notification'] = $notificationText; // Store in session
    }
    




    if(isset($_SESSION['news'])) {
        $news = $_SESSION['news'];
    } else {
        $sql = "SELECT news FROM content_text";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $news = isset($row["news"]) ? $row["news"] : "";
        }
    }
    
    if(isset($_SESSION['notification'])) {
        $notification = $_SESSION['notification'];
    } else {
        $sql = "SELECT notification FROM content_text";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $notification = isset($row["notification"]) ? $row["notification"] : "";
        }
    }
   
 

    
    // Default or initial data when the page loads
    $tableData = [];
    $tableData1=[];
    
    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["category"])) {
            $selectedCategory = $_POST["category"];
            // Query the database for students in the selected category
            $query = "SELECT username, gender, address, department, year, dob, category, contact 
            FROM users 
            WHERE category = '$selectedCategory' 
            ORDER BY 
              CASE 
                WHEN year = 'FE' THEN 1 
                WHEN year = 'SE' THEN 2 
                WHEN year = 'TE' THEN 3 
                WHEN year = 'BE' THEN 4 
                ELSE 5 
              END ASC,
              CASE 
                WHEN department = 'Computer' THEN 1 
                WHEN department = 'Mechanical' THEN 2 
                WHEN department = 'Civil' THEN 3 
                ELSE 4 
              END ASC,
              year ASC";
        
    
    
          $result = mysqli_query($conn, $query);
    
            if ($result && mysqli_num_rows($result) > 0) {
                // Build the table data
                while ($row = mysqli_fetch_assoc($result)) {
                    $tableData[] = $row;
                }
                mysqli_free_result($result); // Free the result set
            }
        }
    
       
    }
    
        if (isset($_POST["year"])) {
            $year = $_POST["year"];
            // Query the database for students in the selected category
            $query = "SELECT username, gender, address, department, year, dob, category, contact 
            FROM users 
            WHERE year = '$year' 
            ORDER BY 
              CASE 
                WHEN year = 'FE' THEN 1 
                WHEN year = 'SE' THEN 2 
                WHEN year = 'TE' THEN 3 
                WHEN year = 'BE' THEN 4 
                ELSE 5 
              END ASC,
              CASE 
                WHEN department = 'Computer' THEN 1 
                WHEN department = 'Mechanical' THEN 2 
                WHEN department = 'Civil' THEN 3 
                ELSE 4 
              END ASC,
              year ASC";
        
    
    
          $result = mysqli_query($conn, $query);
    
            if ($result && mysqli_num_rows($result) > 0) {
                // Build the table data
                while ($row = mysqli_fetch_assoc($result)) {
                    $tableData1[] = $row;
                }
                mysqli_free_result($result); // Free the result set
            }
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
        
        $conn->close();


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Student-Report</title>
  <style>
    .table_data{
    height: auto;
    width: auto;
    margin-left: 100px;
    margin-top: 10vh;
}

table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid #003355; /* Adding border to the table */
        }

        th, td {
            border: 1px solid #003355; /* Adding borders to table cells */
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #003355; /* Setting background color for table heading */
            color: white;
        }

        input[type="submit"] {
            background-color:#0256bd ; /* Setting button color */
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            margin-left: 15vh;

            border-radius: 12px;

        }
        .Buttons{
            margin:20px 5px 5px;
        }

        .pdf-link {
            display: inline-block;
            padding: 8px 12px;
            background-color: #003355;
            border-radius: 14px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            margin-left:8px;
            width:auto;
            height:auto;
        }

        .pdf-link:hover {
            background-color: #005d91;
            color:white;
            text-decoration: none;

        }
        #heading{
            font-family:emoji,serif;
            width:auto;
            height:auto;
            background-color: #003355;
            text-align: center;
         color: white;
         border-radius: 10px;
        }
        label{
            margin-top: 35px;
    padding: 5px 6px;
    background-color: #003355;
    color: white;
    width: auto;
    margin-left: 15px;
    border-radius: 5px;
    height: auto;
        }
select{
    color: white;
    background-color: #054773;
}
      
  </style>
</head>

<body>
  <div class="container">
    <div id="heading">
      <h1>Students Report</h1>
    </div>
    <form method="post" action='student_repo.php'>
      <label for="category">Select Category:</label>
      <select name="category" id="category">
        <option value="" disabled selected>Select Category</option>
        <!-- Options for categories -->
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
      <input type="submit" value="Filter" class="Buttons">
      <a href="gdata.php?category=<?php echo urlencode($selectedCategory); ?>" class="pdf-link">Generate PDF</a>
    </form>

    <!-- Display table -->
    <?php if (!empty($tableData)): ?>
      <table>
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
                <form method='post'>
                  <input type='hidden' name='delete_name' value='<?php echo $row['username']; ?>'>
                  <input type='submit' name='delete_submit' value='Delete' style='background-color: red; color: white;'>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <form action="" method="post" style="padding: 15px;">
      <label for="year">Select Year:</label>
      <select name="year" id="year">
        <option value="" disabled selected>Select Year</option>
        <!-- Options for categories -->
        <option value="FE">FE</option>
        <option value="SE">SE</option>
        <option value="TE">TE</option>
        <option value="BE">BE</option>
      </select>
      <input type="submit" value="Filter" class="Buttons">
      <a href="gdata.php?year=<?php echo urlencode($year); ?>" class="pdf-link">Generate PDF</a>

      <?php if (!empty($tableData1)): ?>
        <table>
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
            <?php foreach ($tableData1 as $row): ?>
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
                  <form method='post'>
                    <input type='hidden' name='delete_name' value='<?php echo $row['username']; ?>'>
                    <input type='submit' name='delete_submit' value='Delete' style='background-color: red; color: white;'>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </form>
  </div>
  </div>
  </div>
</body>

</html>
