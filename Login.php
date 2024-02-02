<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
    header("location: welcome.php");
    exit;
}

require_once "config.php";

$DB_SERVER = "localhost";
$DB_USERNAME = "root";
$DB_PASSWORD = "";
$DB_NAME = "login";

$username = $password = $email = "";
$err = "";

// Establish a database connection using mysqli
$conn = mysqli_connect($DB_SERVER, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// If the request method is POST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
        $err = "Please enter username and password";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }

    if (empty($err)) {
        // Check if the username is "admin"
        if ($username === "admin") {
            // Check if the entered password matches your predefined admin password
            $adminPassword = "your_set_password"; // Replace with your actual admin password
            if ($password === $adminPassword) {
                // Username and password match for the "admin" user
                $_SESSION["username"] = $username;
                $_SESSION["role"] = "admin"; // Set admin role
                $_SESSION["loggedin"] = true;

                // Redirect admin to welcome page
                header("location: welcome.php");
                exit;
            } else {
                $err = "Incorrect password for admin";
            }
        } else {
            // For non-admin users (assuming they are students)
            if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
                $err = "Please enter email and password";
            } else {
                $email = trim($_POST['username']);
                $userPassword = trim($_POST['password']);

                if (empty($err)) {
                    // Check the database for the user with the provided email
                    $sql = "SELECT * FROM users WHERE student_email = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("s", $email);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                        $row = $result->fetch_assoc();
                        $hashedPasswordFromDB = $row['password']; // Assuming the password field in DB is named 'password'

                        // Verify the hashed password against the user's input
                        if (password_verify($userPassword, $hashedPasswordFromDB)) {
                            session_start();
                            $_SESSION["username"] = $row['student_email']; // Adjust with your user data
                            $_SESSION["role"] = "student"; // Assuming 'role' is a column in your database
                            $_SESSION["loggedin"] = true;

                            // Redirect user to student dashboard
                            header("location: student.php");
                            exit;
                        } else {
                            // Incorrect password
                            $err = "Invalid email or password";
                        }
                    } else {
                        // No user found with the provided email
                        $err = "Invalid email or password";
                    }
                }
            }
        }
    }
}
?>





<!-- <!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <!-- <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> -->

    <!-- Bootstrap CSS -->
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>PHP login system!</title>
  </head>
  <body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">Php Login System</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
  <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Register.php">Register</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Login.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Lsogout.php">Logout</a>
      </li>

      
     
    </ul>
  </div>
</nav> --> 

<!-- <h3>Please Login Here:</h3>
<hr> -->

<!-- <div class="container mt-4">
<form action="" method="post">
  <div class="form-group">
    <label for="exampleInputEmail1">Username</label>
    <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password">
  </div>

  <button type="submit" class="btn btn-primary">Submit</button>
</form>



</div> -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

















<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="Login.css"> <!-- Replace this with the appropriate CSS file -->
  <title>NSS OFFICIAL</title>
  <style>
    /* Additional styles can be added here */
  </style>
</head>
<body>
  <section>
    <div class="form-box login_form_container" id="formBox">
      <!-- ... your existing HTML code ... -->
      <div class="form-value login_form">
        <form action="" method="post">
          <h2>Login</h2>
          <div class="inputbox input_group">
            <ion-icon name="mail-outline"></ion-icon>
            <input type="text" name="username" id="text" class="input_text" aria-describedby="emailHelp" placeholder="Enter Username" required>
            <label for="">Email</label>
          </div>
          <div class="inputbox input_group">
            <ion-icon name="lock-closed-outline"></ion-icon>
            <input type="password" name="password" class="input_text" placeholder="Enter Password" required>
            <label for="">Password</label>
          </div>
          <div class="forget">
            <label for=""><input type="checkbox">Remember Me<a href="forgot_pass.php">Forget Password</a></label>
          </div> 
          <div class="button_group" id="login_button">
            <button type="submit" class="custom_submit_button">Log in</button>
          </div>
          <div class="register">
            <p>Don't have an account <a href="./Form.html">Register</a></p>
          </div>
        </form>
      </div>
    </div>
  </section>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script>
    const formBox = document.getElementById('formBox');
    const usernameInput = document.querySelector('input[name="username"]');
    const passwordInput = document.querySelector('input[name="password"]');
    
    usernameInput.addEventListener('focus', increaseBackdropBlur);
    usernameInput.addEventListener('blur', resetBackdropBlur);
    passwordInput.addEventListener('focus', increaseBackdropBlur);
    passwordInput.addEventListener('blur', resetBackdropBlur);
    
    function increaseBackdropBlur() {
      formBox.style.backdropFilter = 'blur(5.2px)';
    }
    
    function resetBackdropBlur() {
      formBox.style.backdropFilter = 'blur(1.5px)';
    }
  </script>
</body>
</html>

