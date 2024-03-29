<?php
require('config.php');
session_start();



$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'login';


$conn = new mysqli($servername, $username, $password, $dbname);
$student_name = isset($_SESSION['username']) ? $_SESSION['username'] : '';





if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $username = $_POST['username'];
  $father_name = $_POST['father_name'];
  $surname = $_POST['surname'];
  $rollno = $_POST['rollno'];
  $gender = $_POST['gender'];
  $address = $_POST['address'];
  $department = $_POST['department'];
  $year = $_POST['year'];
  $dob = $_POST['dob'];
  $contact = $_POST['contact'];
  $city = $_POST['city'];
  $zip = $_POST['zip'];
  $student_email = $_POST['student_email'];
  $hobbies = $_POST['hobbies'];
  $special_interest = $_POST['special_interest'];
  $blood_group = $_POST['blood_group'];
  $height = $_POST['height'];
  $voter = $_POST['voter'];
  $voter_id = $_POST['voter_id'];
  $worked_in_nss = isset($_POST['worked_in_nss']) ? $_POST['worked_in_nss'] : '';
  $toilet_attached = isset($_POST['toilet_attached']) ? $_POST['toilet_attached'] : '';
  
  $parent_name = $_POST['parent_name'];
  $parent_contact = $_POST['parent_contact'];
  $parent_email = $_POST['parent_email'];
  $office_address = $_POST['office_address'];
  $mother_name = $_POST['mother_name'];
  $relationship = $_POST['relationship'];
  $profession = $_POST['profession'];
  $category = $_POST['category'];

  echo $student_email , $parent_email;

  $sql_update = "UPDATE users SET username = '$username', father_name = '$father_name', surname = '$surname', rollno = '$rollno', gender = '$gender', address = '$address', department = '$department', year = '$year', dob = '$dob', contact = '$contact', city = '$city', zip = '$zip', student_email = '$student_email', hobbies = '$hobbies', special_interest = '$special_interest', blood_group = '$blood_group', height = '$height', voter = '$voter', voter_id = '$voter_id', worked_in_nss = '$worked_in_nss', toilet_attached = '$toilet_attached', parent_name = '$parent_name', parent_contact = '$parent_contact',parent_email = '$parent_email', office_address = '$office_address', mother_name = '$mother_name', relationship = '$relationship', profession = '$profession', category = '$category' WHERE student_email = '$student_name'";


  if (mysqli_query($conn, $sql_update)) {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Successful Updation</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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
    </style>

    </head>

    <body>
        <div class="vh-100 d-flex justify-content-center align-items-center">
            <div>
                <div class="mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                        fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                    </svg>
                </div>
                <h1>Thank You !</h1>
                <p>Your NSS Details  was successfully Updated .</p>
                <form action="student.php" method="post">
                    <button type="submit" class="btn btn-outline-primary" name="logout">Back Home</button>
                </form>
            </div>
        </div>
    </body>

    </html>
    <?php
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
}

?>