<?php

session_start();
require_once('config.php'); 


// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}


// Access the username
$student = $_SESSION['username'];

// Prepare and execute a SQL query to fetch the user's details from the users table
$sql_users = "SELECT * FROM users WHERE student_email = ?";
$stmt_users = $conn->prepare($sql_users);
$stmt_users->bind_param("s", $student); // Bind the username parameter
$stmt_users->execute();
$result_users = $stmt_users->get_result();

// Check if the user exists in the users table
if ($result_users->num_rows > 0) {
    // Fetch the user details
    while ($row = $result_users->fetch_assoc()) {
        // Access the user's details
        $username = $row['username'];
        // Output or process the user's details here
    }
} else {
    // If the user is not found in the users table, check in the admin table
    $sql_admin = "SELECT * FROM admin WHERE admin_email = ?";
    $stmt_admin = $conn->prepare($sql_admin);
    $stmt_admin->bind_param("s", $student); // Bind the username parameter
    $stmt_admin->execute();
    $result_admin = $stmt_admin->get_result();

    // Check if the user exists in the admin table
    if ($result_admin->num_rows > 0) {
        // Fetch the admin details
        while ($row = $result_admin->fetch_assoc()) {
            // Access the admin's details
            $username = $row['username'];
            // Output or process the admin's details here
        }
    } else {
        echo "No user found with the username: " . $student . " in both users and admin tables.";
    }

    // Close the statement and result for admin table
    $stmt_admin->close();
}

// Close the statement and result for users table
$stmt_users->close();

// Close the database connection
$conn->close();



$target_dir = "uploads"; // Change this to your uploads directory path
$images = [];

// Get image paths from uploads folder (assuming it's accessible)
$files = glob($target_dir . DIRECTORY_SEPARATOR . "*.{jpg,jpeg,png}", GLOB_BRACE);

if ($files !== false) {
    foreach ($files as $file) {
        $images[] = $file;
    }
} else {
    echo "Error reading files from directory.";
}



//Deletion code 
// Check if delete button is clicked and any image is selected for deletion
if (isset($_POST['delete']) && isset($_POST['delete_checkbox'])) {
  $selected_images = $_POST['delete_checkbox'];

  // Loop through selected images and delete them
  foreach ($selected_images as $image_to_delete) {
    $image_path = $target_dir . DIRECTORY_SEPARATOR . $image_to_delete;
    if (unlink($image_path)) {
      // Image deleted successfully
      echo "Image deleted successfully: " . $image_to_delete . "<br>";
      // Remove the deleted image from the $images array to avoid displaying it again
      $image_key = array_search($image_path, $images);
      unset($images[$image_key]);
    } else {
      echo "Error deleting image: " . $image_to_delete . "<br>";
    }
  }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"  rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
          <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
          <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<title>Photo Gallery</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
  }

  .container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    transform: skew(5deg);
  }

  .card {
    flex: 1;
    transition: all 1s ease-in-out;
    height: 350px; /* Set a fixed height for the card */
    position: relative;
    margin-right: 1em;
    overflow: hidden; /* Hide any overflow content */
}

  .card__head {
    color: black;
    background: rgba(255, 30, 173, 0.75);
    padding: 0.5em;
    transform: rotate(-90deg);
    transform-origin: 0% 0%;
    transition: all 0.5s ease-in-out;
    min-width: 100%;
    text-align: center;
    position: absolute;
    bottom: 0;
    left: 0;
    font-size: 1em;
    white-space: nowrap;
  }

  .card:hover {
    flex-grow: 10;
    img {
      filter: grayscale(0);
    }
    .card__head {
      text-align: center;
      top: calc(100% - 2em);
      color: white;
      background: rgba(0, 0, 0, 0.5);
      font-size: 2em;
      transform: rotate(0deg) skew(-5deg);
    }
  }

  .card img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Ensure the entire image is visible within the fixed height */
    transition: all 1s ease-in-out;
    filter: grayscale(100%);
}

.sidebar {
  position: fixed;
  left: 0;
  top: 0;
  height: 100%;
  width: 78px;
  background: #11101D;
  padding: 6px 14px;
  z-index: 99;
  transition: all 0.5s ease;
}

.sidebar.open {
  width: 250px;
}

.sidebar .logo-details {
  height: 60px;
  display: flex;
  align-items: center;
  position: relative;
}

.sidebar .logo-details .icon {
  opacity: 0;
  transition: all 0.5s ease;
}

.sidebar .logo-details .logo_name {
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  opacity: 0;
  transition: all 0.5s ease;
}

.sidebar.open .logo-details .icon,
.sidebar.open .logo-details .logo_name {
  opacity: 1;
}

.sidebar .logo-details #btn {
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  font-size: 22px;
  transition: all 0.4s ease;
  font-size: 23px;
  text-align: center;
  cursor: pointer;
  transition: all 0.5s ease;
}

.sidebar.open .logo-details #btn {
  text-align: right;
}

.sidebar i {
  color: #fff;
  height: 60px;
  min-width: 50px;
  font-size: 28px;
  text-align: center;
  line-height: 60px;
}

.sidebar .nav-list {
  margin-top: 20px;
  height: 100%;
}

.sidebar li {
  position: relative;
  margin: 8px 0;
  list-style: none;
}

.sidebar li .tooltip {
  position: absolute;
  top: -20px;
  left: calc(100% + 15px);
  z-index: 3;
  background: #fff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 15px;
  font-weight: 400;
  opacity: 0;
  white-space: nowrap;
  pointer-events: none;
  transition: 0s;
}

.sidebar li:hover .tooltip {
  opacity: 1;
  pointer-events: auto;
  transition: all 0.4s ease;
  top: 50%;
  transform: translateY(-50%);
}

.sidebar.open li .tooltip {
  display: none;
}

.sidebar input {
  font-size: 15px;
  color: #FFF;
  font-weight: 400;
  outline: none;
  height: 50px;
  width: 100%;
  width: 50px;
  border: none;
  border-radius: 12px;
  transition: all 0.5s ease;
  background: #1d1b31;
}

.sidebar.open input {
  padding: 0 20px 0 50px;
  width: 100%;
}

.sidebar .bx-search {
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  font-size: 22px;
  background: #1d1b31;
  color: #FFF;
}

.sidebar.open .bx-search:hover {
  background: #1d1b31;
  color: #FFF;
}

.sidebar .bx-search:hover {
  background: #FFF;
  color: #11101d;
}

.sidebar li a {
  display: flex;
  height: 100%;
  width: 100%;
  border-radius: 12px;
  align-items: center;
  text-decoration: none;
  transition: all 0.4s ease;
  background: #11101D;
}

.sidebar li a:hover {
  background: #FFF;
}

.sidebar li a .links_name {
  color: #fff;
  font-size: 15px;
  font-weight: 400;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: 0.4s;
}

.sidebar.open li a .links_name {
  opacity: 1;
  pointer-events: auto;
}

.sidebar li a:hover .links_name,
.sidebar li a:hover i {
  transition: all 0.5s ease;
  color: #11101D;
}

.sidebar li i {
  height: 50px;
  line-height: 50px;
  font-size: 18px;
  border-radius: 12px;
}

.sidebar li.profile {
  position: fixed;
  height: 60px;
  width: 78px;
  left: 0;
  bottom: -8px;
  padding: 10px 14px;
  background: #1d1b31;
  transition: all 0.5s ease;
  overflow: hidden;
}

.sidebar.open li.profile {
  width: 250px;
}

.sidebar li .profile-details {
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
}

.sidebar li img {
  height: 45px;
  width: 45px;
  object-fit: cover;
  border-radius: 6px;
  margin-right: 10px;
}

.sidebar li.profile .name,
.sidebar li.profile .job {
  font-size: 15px;
  font-weight: 400;
  color: #fff;
  white-space: nowrap;
}

.sidebar li.profile .job {
  font-size: 12px;
}

.sidebar .profile #log_out {
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  background: #1d1b31;
  width: 100%;
  height: 60px;
  line-height: 60px;
  border-radius: 0px;
  transition: all 0.5s ease;
}

.sidebar.open .profile #log_out {
  width: 50px;
  background: none;
}

.home-section {
  position: relative;
  background: #003355;
  top: 0;
  left: 78px;
  width: calc(100% - 78px);
  transition: all 0.5s ease;
  z-index: 2;
}

.sidebar.open ~ .home-section {
  left: 250px;
  width: calc(100% - 250px);
}

.home-section .text {
  display: inline-block;
  color: white;
  font-size: 25px;
  font-weight: 500;
  margin: 18px
}

/* End of Sidebar CSS */

/* Gallery CSS */
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 10vmin;
  overflow: hidden;
  transform: skew(5deg);
}

.card {
  flex: 1;
  transition: all 1s ease-in-out;
  height: 350px; /* Set a fixed height for the card */
  position: relative;
  margin-right: 1em;
  overflow: hidden; /* Hide any overflow content */
}

.card img {
  width: 100%;
  height: 100%;
  object-fit: contain; /* Ensure the entire image is visible within the fixed height */
  transition: all 1s ease-in-out;
  filter: grayscale(100%);
}

.card__head {
  color: black;
  background: rgba(255, 30, 173, 0.75);
  padding: 0.5em;
  transform: rotate(-90deg);
  transform-origin: 0% 0%;
  transition: all 0.5s ease-in-out;
  min-width: 100%;
  text-align: center;
  position: absolute;
  bottom: 0;
  left: 0;
  font-size: 1em;
  white-space: nowrap;
}

.card:hover {
  flex-grow: 10;
}

.card:hover img {
  filter: grayscale(0);
}

.card:hover .card__head {
  text-align: center;
  top: calc(100% - 2em);
  color: white;
  background: rgba(0, 0, 0, 0.5);
  font-size: 2em;
  transform: rotate(0deg) skew(-5deg);
}
   /* Define the default styles for .navbar and .box1 */
   .navbar {
            width: 100%; /* Adjust this width as needed */
        }

        .box1 {
            margin-top: 75px;
            width: 100%; 
            position: sticky;
            left: 400px;
        }

        /* Media query for smaller screens */
        @media screen and (min-width: 320px) and (max-width: 425px) {
   .box1{
     width:75%;
   }
   .logo{
     margin-top:-24vh;
   }
}

@media screen and (max-width: 765px) {
    .box1 {
        width: 200px; 
        font-size:13px;
    }
    .logo{
      margin-top:-9vh;

    }
}



        @media screen and (max-width: 767px) {
            .navbar, .box1 {
                width: 100%; /* Adjust the width for smaller screens */
            }
        }






        .header {
            display: flex;
            align-items: center;
            flex-wrap: wrap; 
        }

        .logo {
            width: 50px; /* Adjust the size of the logo as needed */
            height: auto;
            margin-right: 10px;
            margin-top:-1vh;
         
        }

        .subtitle {
    display: block; /* Ensure the subtitle is on a new line */
    text-align: center; /* Center the text */
    font-size: smaller; /* Adjust the font size as needed */
    margin-top: 5px; /* Add space between the sentences */
    color: #777; /* Adjust the color as needed */
}

        .box-text {
            margin-top: 5px;
            text-align: center;
        }
        .box2{
            height:100vh;
            width:100%;
            display:flex;
            justify-content:center;
            
        }


.scrolling-text {
    width: 100%;
    height: 50px; /* Set the height of the scrolling area */
    overflow: hidden; /* Hide overflowing content */
    position: relative;
    background-color: #f0f0f0;
    margin-top:50px;
}

.scrolling-text p {
    white-space: nowrap; /* Prevent text from wrapping */
    position: absolute;
    padding:12px 5px 4px;
    animation: scrolling 11s linear infinite; 
    right:0;
    transform: translateX(100%); 
}

@keyframes scrolling {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-350%);
    }
}


</style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #042d41; position: fixed; top: 0; z-index: 999; color: white;">
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
                    <a class="nav-link" href="admin.php"> Access Control </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#"> View Photos </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="Logout.php"> Logout </a>
                </li>
            </ul>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">
                            <img src="https://img.icons8.com/metro/26/000000/guest-male.png">
                            <?php echo "Welcome " . $_SESSION['username'] ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="box1 col-sm-8">
        <div class="header">
            <img src="gmvit_logo-removebg-preview.png" alt="Logo" class="logo">
            <div>
                <h6 style="left=50px;">Sant Gajanant Maharaj Vedak Institute of Technology (GMVIT)
                    <span class="subtitle">Admissions A.Y. 2023-24 Tala Nss Dashboard</span>
                </h6>
                <div class="box-text">
                    Undergraduate Programs in Engineering and Technology (4 Years)
                </div>
            </div>
        </div>
    </div>

  <div class="container">
    <?php foreach ($images as $image): ?>
      <div class="card">
        <img src="<?php echo $image; ?>" alt="Uploaded Photo">
        <div class="card__head"><?php echo basename($image); ?></div>
      </div>
    <?php endforeach; ?>
  </div>



  <h1>Manage Photos</h1>
  <?php if (count($images) > 0): ?>
  <form action="" method="post" enctype="multipart/form-data">
    <p>Select photos to delete:</p>
    <?php foreach ($images as $image): ?>
    <div class="image-container">
      <img src="<?php echo $image; ?>"  style="width: 150px; height: 100px; object-fit: cover;"  alt="Photo">
      <input type="checkbox" name="delete_checkbox[]" value="<?php echo basename($image); ?>">
      <label for="<?php echo basename($image); ?>">Delete</label>
    </div>
    <?php endforeach; ?>
    <button type="submit" name="delete" class="btn btn-danger">Delete Selected Photos</button>
  </form>
  <?php else: ?>
    <p>No photos found in the uploads directory.</p>
  <?php endif; ?>



  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  menuBtnChange();//calling the function(optional)
});

searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
  sidebar.classList.toggle("open");
  menuBtnChange(); //calling the function(optional)
});

// following are the code to change sidebar button(optional)
function menuBtnChange() {
 if(sidebar.classList.contains("open")){
   closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
 }else {
   closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
 }
}

    </script>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
      
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>  

</body>
</html>
