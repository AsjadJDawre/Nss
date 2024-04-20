<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/PHPMailer.php';
require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/SMTP.php';
require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/Exception.php';

// Start a session
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch admin email from the form
    $admin_email = $_POST['admin_email'];

    // Generate a random 6-digit alphanumeric code
    $verification_code = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

    // Send the code to the admin's email
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Set to SMTP::DEBUG_SERVER for debugging
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Gmail SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'projecttesting48@gmail.com'; // Your Gmail email address
        $mail->Password = 'llli cown oder zeuc'; // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use PHPMailer::ENCRYPTION_SMTPS if required
        $mail->Port = 587; // Gmail SMTP port

        //Recipients
        $mail->setFrom('projecttesting48@gmail.com', 'Admin'); // Your Gmail email address and name
        $mail->addAddress($admin_email); // Add recipient email

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Admin Verification Code';
        $mail->Body = '<p>Dear Admin,</p>
                       <p>Your verification code is: <strong>' . $verification_code . '</strong></p>
                       <p>Please use this code to verify your email.</p>
                       <p>Regards,<br>Admin</p>';

        $mail->send();

        // Store the code in the database
        $update_query = "UPDATE admin SET otp='$verification_code' WHERE admin_email='$admin_email'";
        if ($conn->query($update_query) === TRUE) {
            // Redirect to verification page with the email
            header("Location: verify_admin.php?admin_email=$admin_email");
            exit();
        } else {
            echo "Error updating OTP: " . $conn->error;
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">

    <link rel="icon" href="forgot_pass_fav_icon.png" type="image/png">

    <!-- Google Fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Forgot Password UI</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #3758d1;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 7rem;
        }

        .navbar {
            background-color: #042d41;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
        }

        .navbar-brand {
            margin-left: 65px;
        }

        .card {
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            background-color: rgba(0, 0, 0, 0.75);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.125);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 30px 40px;
            margin-top: 9vh;
        }

        .lock-icon {
            font-size: 3rem;
        }

        h2 {
            font-size: 1.5rem;
            margin-top: 10px;
            text-transform: uppercase;
        }

        p {
            font-size: 12px;
        }

        .passInput {
            margin-top: 15px;
            width: 80%;
            background: transparent;
            border: none;
            border-bottom: 2px solid deepskyblue;
            font-size: 15px;
            color: white;
            outline: none;
        }

        .btn {
            margin-top: 15px;
            width: 80%;
            background-color: deepskyblue;
            color: white;
            padding: 10px;
            text-transform: uppercase;
        }

        .header {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container"> <!-- Added container here -->
            <a class="navbar-brand" href="#">Nss Login System</a>
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
                        <a class="nav-link" href="Logout.php"> Logout </a>
                    </li>
                </ul>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png">
                                <?php echo "Welcome "?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <form action="admin.php" method="post">
        <div class="card">
            <p class="lock-icon"><i class="fas fa-lock"></i></p>
            <h2>Admin Verification</h2>
            <p>Enter your Admin Email to receive a verification code.</p>
            <input type="email" name='admin_email' class="passInput" placeholder="Admin Email" autocomplete="off">
            <input type="submit" class="btn" value="Get Verification Code">
        </div>
    </form>

    <!-- Bootstrap JS (Optional) -->
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
