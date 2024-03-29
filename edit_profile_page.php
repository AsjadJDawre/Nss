<?php
require('config.php');

session_start();

$servername = DB_SERVER;
$database = DB_NAME;
$user = DB_USERNAME;
$password = DB_PASSWORD;

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if (!$conn) {
    die('Error: Cannot connect to the database');
}


function fetchStudentData($conn, $student_email) {
  $sql = "SELECT * FROM users WHERE student_email = '$student_email'";
  $result = mysqli_query($conn, $sql);

  if ($result && mysqli_num_rows($result) > 0) {
      return mysqli_fetch_assoc($result);
  } else {
      return null;
  }
}

if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $student_name = $_SESSION['username'];
    $student_data = fetchStudentData($conn, $student_name);

    // print $student_name ;


        if (isset($student_data) && !empty($student_data)) {

        $username = $student_data['username'];
        $father_name = $student_data['father_name'];
        $surname = $student_data['surname'];
        $rollno = $student_data['rollno'];
        $gender = $student_data['gender'];
        $address = $student_data['address'];
        $department = $student_data['department'];
        $year = $student_data['year'];
        $dob = $student_data['dob'];
        $contact = $student_data['contact'];
        $city = $student_data['city'];
        $zip = $student_data['zip'];
        $student_email = $student_data['student_email'];
        $hobbies = $student_data['hobbies'];
        $special_interest = $student_data['special_interest'];
        $blood_group = $student_data['blood_group'];
        $height = $student_data['height'];
        $voter = $student_data['voter'];
        $voter_id = $student_data['voter_id'];
        $worked_in_nss = $student_data['worked_in_nss'];
        $toilet_attached = $student_data['toilet_attached'];
        $parent_name = $student_data['parent_name'];
        $parent_contact = $student_data['parent_contact'];
        $parent_email = $student_data['parent_email'];
        $office_address = $student_data['office_address'];
        $mother_name = $student_data['mother_name'];
        $relationship = $student_data['relationship'];
        $profession = $student_data['profession'];
        $category = $student_data['category'];
    
    }
  } else {
    echo "No data found for the student.";
}
mysqli_close($conn);




?>






<!doctype html>
<html lang="en">
<!-- ... rest of your HTML form ... -->








<!doctype html>
<html lang="en">
<!-- ... rest of your HTML form ... -->









<!doctype html>
<html lang="en">
  <head>
    <!--   meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"  rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
          <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>NSS Enrollment Registration </title>

    <style>
      .custom-input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  margin-bottom: 10px;
}
.error-message {
  color: red;
  display: none;
}
.error-message {
  color: red;
  display: none; /* Hide the error message by default */
}

.form-group{
  padding-top:10px;
  padding-left: 15px;
}

input[type="number"]::-webkit-inner-spin-button{
  display:none;
}



@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");
@import url('https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

.container {
  /* height: auto;
  width: 100%; */
  /* align-items: center; */
  margin-left:3px;
  display: block;
  /* justify-content: center; */
  background-color: #fcfcfc;
}

.card {
  border-radius: 10px;
  box-shadow: 0 5px 10px 0 rgba(0, 0, 0, 0.3);
  max-width: 280px; /* Further reduce the maximum width */
  background-color: #ffffff;
  padding: 8px 12px 16px; /* Further reduce padding */
}

.card h3 {
  font-size: 16px; /* Further reduce font size */
  font-weight: 600;
}


.drop_box {
  margin: 10px 0;
  padding: 10px; /* Further reduce padding */
  display: flex;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  border: 3px dotted #a3a3a3;
  border-radius: 5px;
}

.drop_box h4 {
  font-size: 12px; /* Further reduce font size */
  font-weight: 400;
  color: #2e2e2e;
}

.drop_box p {
  margin-top: 8px;
  margin-bottom: 8px; /* Further reduce margin */
  font-size: 10px; /* Further reduce font size */
  color: #a3a3a3;
}

.btn {
  text-decoration: none;
  background-color: #005af0;
  color: #ffffff;
  padding: 4px 8px; /* Further reduce padding */
  border: none;
  outline: none;
  transition: 0.3s;
}

.btn:hover {
  text-decoration: none;
  background-color: #ffffff;
  color: #005af0;
  padding: 4px 8px; /* Further reduce padding */
  border: none;
  outline: 1px solid #010101;
}

.form input {
  margin: 4px 0; /* Further reduce margin */
  width: 100%;
  background-color: #e2e2e2;
  border: none;
  outline: none;
  padding: 6px 10px; /* Further reduce padding */
  border-radius: 4px;
}

.navbar{
  background-color:#012b47;
  color:white;
}

.navbar-brand,
.navbar-brand:hover {
  color: white; /* Maintain white color for navbar brand */
}

.nav-link {
  color: white;
}

.nav-link:hover {
  color: white;
}


.loader-wrapper {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent overlay */
      z-index: 999; /* Ensure the spinner is on top of other content */
      display: none; /* Initially hide the spinner */
      justify-content: center;
      align-items: center;
      backdrop-filter: blur(5px); /* Background blur effect */
    }
    .loader {
      width: 48px;
      height: 48px;
      border-radius: 50%;
      position: relative;
      animation: rotate 1s linear infinite;
    }
    .loader::before, .loader::after {
      content: "";
      box-sizing: border-box;
      position: absolute;
      inset: 0px;
      border-radius: 50%;
      border: 5px solid #FFF;
      animation: prixClipFix 2s linear infinite;
    }
    .loader::after {
      transform: rotate3d(90, 90, 0, 180deg);
      border-color: #FF3D00;
    }
    @keyframes rotate {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    @keyframes prixClipFix {
      0% { clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0); }
      50% { clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0); }
      75%, 100% { clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%); }
    }
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins" , sans-serif;
}
.sidebar{
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
.sidebar.open{
  width: 250px;
}
.sidebar .logo-details{
  height: 60px;
  display: flex;
  align-items: center;
  position: relative;
}
.sidebar .logo-details .icon{
  opacity: 0;
  transition: all 0.5s ease;
}
.sidebar .logo-details .logo_name{
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  opacity: 0;
  transition: all 0.5s ease;
}
.sidebar.open .logo-details .icon,
.sidebar.open .logo-details .logo_name{
  opacity: 1;
}
.sidebar .logo-details #btn{
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
.sidebar.open .logo-details #btn{
  text-align: right;
}
.sidebar i{
  color: #fff;
  height: 60px;
  min-width: 50px;
  font-size: 28px;
  text-align: center;
  line-height: 60px;
}
.sidebar .nav-list{
  margin-top: 20px;
  height: 100%;
}
.sidebar li{
  position: relative;
  margin: 8px 0;
  list-style: none;
}
.sidebar li .tooltip{
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
.sidebar li:hover .tooltip{
  opacity: 1;
  pointer-events: auto;
  transition: all 0.4s ease;
  top: 50%;
  transform: translateY(-50%);
}
.sidebar.open li .tooltip{
  display: none;
}
.sidebar input{
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
.sidebar.open input{
  padding: 0 20px 0 50px;
  width: 100%;
}
.sidebar .bx-search{
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  font-size: 22px;
  background: #1d1b31;
  color: #FFF;
}
.sidebar.open .bx-search:hover{
  background: #1d1b31;
  color: #FFF;
}
.sidebar .bx-search:hover{
  background: #FFF;
  color: #11101d;
}
.sidebar li a{
  display: flex;
  height: 100%;
  width: 100%;
  border-radius: 12px;
  align-items: center;
  text-decoration: none;
  transition: all 0.4s ease;
  background: #11101D;
}
.sidebar li a:hover{
  background: #FFF;
}
.sidebar li a .links_name{
  color: #fff;
  font-size: 15px;
  font-weight: 400;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: 0.4s;
}
.sidebar.open li a .links_name{
  opacity: 1;
  pointer-events: auto;
}
.sidebar li a:hover .links_name,
.sidebar li a:hover i{
  transition: all 0.5s ease;
  color: #11101D;
}
.sidebar li i{
  height: 50px;
  line-height: 50px;
  font-size: 18px;
  border-radius: 12px;
}
.sidebar li.profile{
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
.sidebar.open li.profile{
  width: 250px;
}
.sidebar li .profile-details{
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
}
.sidebar li img{
  height: 45px;
  width: 45px;
  object-fit: cover;
  border-radius: 6px;
  margin-right: 10px;
}
.sidebar li.profile .name,
.sidebar li.profile .job{
  font-size: 15px;
  font-weight: 400;
  color: #fff;
  white-space: nowrap;
}
.sidebar li.profile .job{
  font-size: 12px;
}
.sidebar .profile #log_out{
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
.sidebar.open .profile #log_out{
  width: 50px;
  background: none;
}
.home-section{
  position: relative;
  background: #003355;
  top: 0;
  left: 78px;
  width: calc(100% - 78px);
  transition: all 0.5s ease;
  z-index: 2;
}
.sidebar.open ~ .home-section{
  left: 250px;
  width: calc(100% - 250px);
}
.home-section .text{
  display: inline-block;
  color: white;
  font-size: 25px;
  font-weight: 500;
  margin: 18px
}
@media (max-width: 420px) {
  .sidebar li .tooltip{
    display: none;
  }
}


</style>
  </head>
  <body>
  <form id="mainForm" action="" method="post" enctype="multipart/form-data">
  <div class="sidebar">
      <div class="logo-details">
        <i class="bx bx-user"></i>
        <div class="logo_name"></div>
        <i class="bx bx-menu" id="btn"></i>
      </div>
      <ul class="nav-list" style="    margin-left: -28px;
">
        <li>
          <div class="profile-details">
          <!-- <?php
// $studentEmail = $row['student_email'];
// $sql = "SELECT photo FROM users WHERE student_email = '$studentEmail'";
// $result = mysqli_query($conn, $sql);

// if ($result && mysqli_num_rows($result) > 0) {
//   $photoRow = mysqli_fetch_assoc($result);
//   $photoName = $photoRow['photo'];
//   $photoPath = "C:/xampp/htdocs/NSS/images/" . $photoName;

//   // Check if the photo path is not empty and the file exists
//   if (!empty($photoPath) && file_exists($photoPath)) {
//     echo '<img src="' . $photoPath . '" alt="profileImg" />';
//   } else {
//     // Display a default image if the photo path is empty or the file doesn't exist
//     echo '<img src="default_profile.jpg" alt="profileImg" />';
//   }
// } else {
//   // Display a default image if there is an error fetching the photo
//   echo '<img src="profile.jpg" alt="profileImg" />';
// }
// ?> -->
<div class="name_job">
            </div>
          </div>
        </li>
        <li>
          <a href="student.php">
            <i class="bx bx-home"></i>
            <span class="links_name">Home</span>
          </a>
          <span class="tooltip">Home</span>
        </li>
        <li>
          <a href="Logout.php">
            <i class="bx bx-log-out"></i>
            <span class="links_name">Logout</span>
          </a>
          <span class="tooltip">Logout</span>
        </li>
        <li>
          <a href="edit_profile_page.php">
            <i class="bx bx-edit"></i>
            <span class="links_name">Edit Profile</span>
          </a>
          <span class="tooltip">Edit Profile</span>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-question-mark"></i>
            <span class="links_name">Help and Support</span>
          </a>
          <span class="tooltip">Help and Support</span>
        </li>
        <li>
          <div class="welcome-message">
          
          </div>
        </li>
      </ul>
    </div>
    <section class="home-section">
      <div class="text">Profile</div>
    </section>
  
    <div class="moved_cent" style="    margin-left: 15vh;
">

<div class="container mt-4">
<h1 >Please Review Your Data Here :</h1>
<hr>
<form action="update_student.php" method="post" enctype="multipart/form-data">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="username">Your Name (Fill All The information In Capital Case)</label>
      <input type="text" class="form-control" name="username" id="your_name"value="<?php echo isset($username) ? $username : ''; ?>">
    </div>
      <div class="form-group">
      <label for="father_name">Your Father name </label>
      <input type="text" class="form-control" name="father_name" id="father_name" value="<?php echo isset($father_name) ? $father_name : ''; ?>">
    </div>   
    
    <div class="form-group">
      <label for="surname">Your  Surname  </label>
      <input type="text" class="form-control" name="surname" id="surname" value="<?php echo isset($surname) ? $surname : ''; ?>">
    </div>
    <div class="form-group">
      <label for="surname">Your  RollNO  </label>
      <input type="text" class="form-control" name="rollno" id="rollno" value="<?php echo isset($rollno) ? $rollno : ''; ?>">
    </div>

    <div class="form-group col-md-6">
    <label for="email">Your Email:</label>
    <input type="email" class="form-control" id="email" name="student_email" readonly value="<?php echo isset($student_email) ? $student_email : ''; ?>">
</div>


   

   <!-- Address -->
   <div class="form-group">
    <label for="address">Address</label>
    <input type="text" class="form-control" id="address" name="address" required value="<?php echo isset($address) ? $address : ''; ?>">
</div>




  <!-- 19-september update  -->
  <!-- Gender  -->
  <div class="form-group">
  <label for="gender">Gender</label>
  <select class="form-control" id="gender" name="gender" required >
  <option value="Male" <?php echo ($gender === 'Male') ? 'selected' : ''; ?>>Male</option> 
  <option value="Female" <?php echo ($gender === 'Female') ? 'selected' : ''; ?>>Female</option> 
    <option value="other">Other</option>
  </select>
</div>


<!-- Branch -->
<div class="form-group">
  <label for="department">Select Department</label>
  <select class="form-control" id="department" name="department" required>
    <option value="Computer" <?php echo ($department === 'Computer') ? 'selected' : ''; ?>>Computer</option>
    <option value="Mechanical" <?php echo ($department === 'Mechanical') ? 'selected' : ''; ?>>Mechanical</option>
    <option value="Civil" <?php echo ($department === 'Civil') ? 'selected' : ''; ?>>Civil</option>
  </select>
</div>

<!-- Year -->
<div class="form-group">
  <label for="year">Select Year</label>
  <select class="form-control" id="year" name="year" required >
    <option value="FE" <?php echo ($year === 'FE') ? 'selected' : ''; ?>>FE</option> 
    <option value="SE" <?php echo ($year === 'SE') ? 'selected' : ''; ?>>SE</option> 
    <option value="TE"  <?php echo ($year === 'TE') ? 'selected' : ''; ?>>TE</option> 
    <option value="BE"  <?php echo ($year === 'BE') ? 'selected' : ''; ?>>BE</option> 
  </select>
</div>








<!-- Castes  -->
<div class="form-group">
  <label for="category">Select Category</label>
  <select class="form-control" id="category" name="category" size="1" required>
    <!-- <option value="FE" selected>Select A category </option>   -->
    <option value="Open" <?php echo ($category === 'Open') ? 'selected' : ''; ?>>Open</option> 
    <option value="OBC" <?php echo ($category === 'OBC') ? 'selected' : ''; ?>>OBC</option> 
    <option value="Scheduled Castes (SC)" <?php echo ($category === 'Scheduled Castes (SC)') ? 'selected' : ''; ?>>Scheduled Castes (SC)</option> 
    <option value="Scheduled Tribe (ST)" <?php echo ($category === 'Scheduled Tribe (ST)') ? 'selected' : ''; ?>>Scheduled Tribe (ST)</option> 
    <option value="Vimukta Jati (VJ) / De-Notified Tribes (DT) (NT-A)" <?php echo ($category === 'Vimukta Jati (VJ) / De-Notified Tribes (DT) (NT-A)') ? 'selected' : ''; ?>>Vimukta Jati (VJ) / De-Notified Tribes (DT) (NT-A)</option> 
    <option value="Nomadic Tribes 1 (NT-B)" <?php echo ($category === 'Nomadic Tribes 1 (NT-B)') ? 'selected' : ''; ?>>Nomadic Tribes 1 (NT-B)</option> 
    <option value="Nomadic Tribes 2 (NT-C)" <?php echo ($category === 'Nomadic Tribes 2 (NT-C)') ? 'selected' : ''; ?>>Nomadic Tribes 2 (NT-C)</option> 
    <option value="Nomadic Tribes 3 (NT-D)" <?php echo ($category === 'Nomadic Tribes 3 (NT-D)') ? 'selected' : ''; ?>>Nomadic Tribes 3 (NT-D)</option> 
    <option value="Other Backward Classes (OBC)" <?php echo ($category === 'Other Backward Classes (OBC)') ? 'selected' : ''; ?>>Other Backward Classes (OBC)</option> 
    <option value="Socially and Educationally Backward Classes (SEBC)" <?php echo ($category === 'Socially and Educationally Backward Classes (SEBC)') ? 'selected' : ''; ?>>Socially and Educationally Backward Classes (SEBC)</option> 
  </select>
</div>









<!-- Age -->
<div class="form-group">
  <label for="dob">Enter Your DOB</label>
  <input type="text" class="form-control" id="dob" name="dob" required value="<?php echo isset($dob) ? $dob : ''; ?>">
</div>
















  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" name="city" class="form-control" id="inputCity" required value="<?php echo isset($city) ? $city : ''; ?>">
    </div>
    <div class="form-group col-md-4">
    <label for="phoneNumber">Mobile No.</label>
        <input type="text" id="phoneNumber" name='contact'   class="form-control custom-input"  placeholder="Enter your mobile number" required value="<?php echo isset($contact) ? $contact : ''; ?>">
        <p id="error-message" class="error-message">Invalid mobile number</p>

    </div> 




    </div>
    <div class="form-group col-md-2">
        <label for="inputZip">Zip</label>
        <input type="number" id="inputZip" name="zip" class="form-control" placeholder="Enter your 6-Digit zip code" required value="<?php echo isset($zip) ? $zip : ''; ?>">
    </div>
  </div>


  <h2>Parent/Guardian Information </h2>


  <div class="form-group col-md-6">
    <label for="email">Email:</label>
    <input type="email" class="form-control" id='email' name="parent_email" required value="<?php echo isset($parent_email) ? $parent_email : ''; ?>">
</div>

<div class="form-group">
    <label for="hobbies">Hobbies/Interest:</label>
    <input type="text" class="form-control" id='hobbies' name="hobbies" required value="<?php echo isset($hobbies) ? $hobbies : ''; ?>">
</div>

<div class="form-group">
    <label for="special_interest">Special Interest:</label>
    <input type="text" class="form-control" id='special_interest' name="special_interest" required value="<?php echo isset($special_interest) ? $special_interest : ''; ?>">
</div>

<div class="form-group">
    <label for="blood_group">Blood Group:</label>
    <input type="text" class="form-control" id='blood_group' name="blood_group" required value="<?php echo isset($blood_group) ? $blood_group : ''; ?>">
</div>

<div class="form-group">
    <label for="height">Height (in cm):</label>
    <input type="number" class="form-control" id='height' name="height" required value="<?php echo isset($height) ? $height : ''; ?>">
</div>
</div>

<div class="form-group">
    <label>Enrolled as Voter:</label>
    <div class="form-check">
        <input type="radio" class="form-check-input" name="voter" id="voter_yes" value="Yes" <?php echo ($voter === 'Yes') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="voter_yes">Yes</label>
    </div>
    <div class="form-check">
        <input type="radio" class="form-check-input" name="voter" id="voter_no" value="No" <?php echo ($voter === 'No') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="voter_no">No</label>
    </div>
</div>

<div id="voter_id_section" <?php echo ($voter === 'Yes') ? 'style="display: block;"' : 'style="display: none;"'; ?>>
    <div class="form-group">
        <label for="voter_id">Voter ID No.:</label>
        <input type="text" class="form-control" id="voter_id" name="voter_id" value="<?php echo isset($voter_id) ? $voter_id : ''; ?>" <?php echo ($voter === 'Yes') ? 'required' : ''; ?>>
    </div>
</div>


<div class="form-group">
    <label>Have you worked in NSS/NCC/Scout/Guide/Other:</label>
    <div class="form-check">
        <input type="radio" class="form-check-input" name="worked_in_nss" id="nss_yes" value="Yes" <?php echo ($worked_in_nss === 'Yes') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="nss_yes">Yes</label>
    </div>
    <div class="form-check">
        <input type="radio" class="form-check-input" name="worked_in_nss" id="nss_no" value="No" <?php echo ($worked_in_nss === 'No') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="nss_no">No</label>
    </div>
</div>


<div class="form-group">
    <label>Toilet attached to your House:</label>
    <div class="form-check">
        <input type="radio" class="form-check-input" name="toilet_attached" id="toilet_yes" value="Yes" <?php echo ($toilet_attached === 'Yes') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="toilet_yes">Yes</label>
    </div>
    <div class="form-check">
        <input type="radio" class="form-check-input" name="toilet_attached" id="toilet_no" value="No" <?php echo ($toilet_attached === 'No') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="toilet_no">No</label>
    </div>
</div>



<div class="form-group">
    <label for="parent_name">Parents/Guardians Full Name:</label>
    <input type="text" class="form-control" id='parent_name' name="parent_name" required value="<?php echo isset($parent_name) ? $parent_name : ''; ?>">
</div>

<div class="form-group">
    <label for="office_address">Office Address:</label>
    <input type="text" class="form-control" id='office_address' name="office_address" required value="<?php echo isset($office_address) ? $office_address : ''; ?>">
</div>

<div class="form-group">
    <label for="mother_name">Mothers Name:</label>
    <input type="text" class="form-control" id='mother_name' name="mother_name" required value="<?php echo isset($mother_name) ? $mother_name : ''; ?>">
</div>


<div class="form-group">
    <label for="parent_contact">Parents/Guardian Contact Number:</label>
    <input type="tel" class="form-control" id='parent_contact' name="parent_contact" required value="<?php echo isset($parent_contact) ? $parent_contact : ''; ?>">
</div>

<div class="form-group">
    <label for="relationship">Relationship with Student:</label>
    <input type="text" class="form-control" id='relationship' name="relationship" required value="<?php echo isset($relationship) ? $relationship : ''; ?>">
</div>

<div class="form-group">
    <label for="profession">Profession:</label>
    <input type="text" class="form-control" id='profession' name="profession" required value="<?php echo isset($profession) ? $profession : ''; ?>">
</div>





 <!-- Photo Identity  -->
 <div class="form-group">
                <div class="container">
                    <div class="card">
                    <label>Title</label>
    <input type="text" name="title">
                        <h3>Upload Your Recent Photo</h3>
                        <div class="drop_box">
                            <header>
                                <h4>Select File here</h4>
                            </header>
                            <p>Files Supported: PDF, TEXT, DOC, DOCX</p>
                            <input type="file" hidden accept=".doc,.docx,.pdf" name="photo" id="photo" style="display: none;">
                            <button type="button" class="btn" id="choose-file">Choose File</button>
                        </div>
                    </div>
                </div>
            </div>






  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck" style="
    border: 2px solid black;
">
      <label class="form-check-label" for="gridCheck">
        I hereby Informed that all My Details are Genuine. <br> And I am Aware that it will be Used Throughout My NSS Enrollement
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary" name="pdf_data">Generate PDF</button>
  <button type="submit" class="btn btn-primary" name="update">UPDATE</button>

  <div class="loader-wrapper" id="loaderWrapper">
    <span class="loader"></span>
  </div>

</form>
</div>

</form>
<script>
  document.getElementById('mainForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent the default form submission

    // Get the name attribute of the button that was clicked
    const clickedButton = document.activeElement.name;

    // Set the action URL based on the button clicked
    if (clickedButton === 'update') {
      this.action = 'update_student.php'; // Set the action for updating data
    } else if (clickedButton === 'pdf_data') {
      this.action = 'getdata.php'; // Set the action for generating PDF
    }

    // Submit the form with the updated action
    this.submit();
  });
</script>
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
<script>
  Loading spinner
document.querySelector('form').addEventListener('submit', function(event) {
  // Prevent the default form submission
  event.preventDefault();

  // Show the loader when the form is submitted
  document.getElementById('loaderWrapper').style.display = 'flex';

  // Hide the loader after 4 seconds (4000 milliseconds)
  setTimeout(function() {
    // Submit the form to update_profile.php after 4 seconds
    document.querySelector('form').action = 'update_student.php';
    document.querySelector('form').submit();
  }, 4000); // 4 seconds
});







function validateForm(event) {
    event.preventDefault(); // Prevent form submission by default

    // Check if either "Yes" or "No" is selected for "Have you worked in NSS/NCC/Scout/Guide/Other"
    const nssYesSelected = document.getElementById('nss_yes').checked;
    const nssNoSelected = document.getElementById('nss_no').checked;

    // Check if either "Yes" or "No" is selected for "Toilet attached to your House"
    const toiletYesSelected = document.getElementById('toilet_yes').checked;
    const toiletNoSelected = document.getElementById('toilet_no').checked;

    // Display error message if any of the inputs is empty
    if (!nssYesSelected && !nssNoSelected) {
        alert('Please select an option for "Have you worked in NSS/NCC/Scout/Guide/Other?"');
        return false; // Prevent form submission
    }

    if (!toiletYesSelected && !toiletNoSelected) {
        alert('Please select an option for "Toilet attached to your House"');
        return false; // Prevent form submission
    }

    // If both inputs are selected, submit the form
    document.getElementById('myForm').submit();
}


</script>








<script>

const phoneNumberInput = document.getElementById("phoneNumber");
const errorMessage = document.getElementById("error-message");

phoneNumberInput.addEventListener("input", () => {
  const phoneNumber = phoneNumberInput.value;

  // Remove any non-numeric characters
  const cleanNumber = phoneNumber.replace(/\D/g, '');

  if ((cleanNumber.length === 10 || cleanNumber.length === 11 || cleanNumber.length === 12) &&
      (cleanNumber.match(/^[6-9]\d+$/) || cleanNumber.match(/^0\d+$/) || cleanNumber.match(/^91\d+$/))) {
    errorMessage.style.display = "none";
  } else {
    errorMessage.style.display = "inline";
  }
});

</script>


<script>

document.getElementById("choose-file").addEventListener("click", function () {
            document.getElementById("photo").click();
        });

        document.getElementById("photo").addEventListener("change", function () {
            // Update the button text to show the selected file name
            const selectedFile = this.files[0];
            if (selectedFile) {
                document.getElementById("choose-file").textContent = selectedFile.name;
            } else {
                document.getElementById("choose-file").textContent = "Choose File";
            }
        });

        // Prevent the form from submitting when the "Choose File" button is clicked
        document.getElementById("choose-file").addEventListener("click", function (e) {
            e.preventDefault();
        });

        // Prevent the form from submitting when pressing Enter in the file input
        document.getElementById("photo").addEventListener("keypress", function (e) {
            if (e.keyCode === 13) {
                e.preventDefault();
            }
        });
        </script>
        <script>

        const voterRadio = document.getElementsByName('voter');
        const voterIdSection = document.getElementById('voter_id_section');

        for (let radio of voterRadio) {
            radio.addEventListener('change', function() {
                if (radio.value === 'yes') {
                    voterIdSection.style.display = 'block';
                } else {
                    voterIdSection.style.display = 'none';
                }
            });
        }


</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>