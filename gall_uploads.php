<?php
session_start();
require_once('config.php'); 
// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header("location: login.php");
  exit();
}




$target_dir = "C:\\xampp\\htdocs\\NSS\\uploads";
$message = "";

if (isset($_FILES["files"])) {
  $allowed_extensions = array("jpg", "jpeg", "png");
  $total = count($_FILES['files']['name']);

  for ($i = 0; $i < $total; $i++) {
    $filename = $_FILES['files']['name'][$i];
    $file_tmp = $_FILES['files']['tmp_name'][$i];
    $file_type = pathinfo($filename, PATHINFO_EXTENSION);

    if (in_array($file_type, $allowed_extensions)) {
      $target_file = $target_dir . DIRECTORY_SEPARATOR . basename($filename);

      if (move_uploaded_file($file_tmp, $target_file)) {
        $message .= "<p class='message'>The file " . basename($filename) . " has been uploaded.</p>";
      } else {
        $message .= "<p class='error'>Sorry, there was an error uploading " . basename($filename) . ".</p>";
      }
    } else {
      $message .= "<p class='error'>Sorry, only JPG, JPEG & PNG files are allowed.</p>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
          <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<title>Upload Photos</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
  }

  .container {
    margin: 50px auto;
    width: 500px;
    padding: 20px;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  }
  
  #upload-form {
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  
  input[type="file"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  
  input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }
  
  .message, .error {
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
  }
  
  .message {
    background-color: #d4edda;
    color: #155724;
  }
  
  .error {
    background-color: #f8d7da;
    color: #721c24;
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
                    <a class="nav-link" href="#">Events</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="admin.php"> Access Control </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="gallery_admin.php"> View Photos </a>
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
    <h1>Upload Multiple Photos</h1>
    <form id="upload-form" method="post" enctype="multipart/form-data" action="">
      <input type="file" id="files" name="files[]" multiple>
      <input type="submit" value="Upload Photos">
    </form>
    <div id="message"><?php echo $message; ?></div>
  </div>

  <!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
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
