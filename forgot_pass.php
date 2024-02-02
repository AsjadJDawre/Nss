<?php
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

require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/PHPMailer.php';
require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/SMTP.php';
require 'PHPMailer-6.9.1/PHPMailer-6.9.1/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the entered email from the form
    $studentEmail = $_POST['Student_email'];

    // Validate email (you might want to add more robust validation)
    if (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit();
    }

    // Check if the email exists in the database
    $sql = "SELECT * FROM users WHERE student_email = '$studentEmail'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email exists, generate and send a one-time password (OTP) or a password reset link
        $otp = generateOTP(); // Implement this function to generate a secure OTP

        // Update the OTP in the database
        $update_otp = "UPDATE users SET otp='$otp' WHERE student_email = '$studentEmail'";
        if ($conn->query($update_otp) === FALSE) {
            echo "Error updating OTP: " . $conn->error;
            exit();
        }

        // Store the OTP and email in session for verification during password reset
        $_SESSION['reset_email'] = $studentEmail;
        $_SESSION['reset_otp'] = $otp;

        // Send the OTP to the user via email using PHPMailer
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
            $mail->addAddress($studentEmail); // Add recipient email

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your one-time password (OTP) for password reset: $otp";

            $mail->send();

            // Redirect to recover_email.php with student info
            header("Location: recover_email.php");
            exit();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Email not found in the database, destroy the session
        session_destroy();
        echo "Email not found in the database";
        exit();
    }
}

// Close the database connection
$conn->close();

// Function to generate a random 6-digit OTP
function generateOTP() {
    return rand(100000, 999999);
}
?>








<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome Icons  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
        <link rel="icon" href="forgot_pass_fav_icon.png" type="image/png">

    <!-- Google Fonts  -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Forgot Password UI </title>
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
    padding: 15rem 0;
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
    </style>
</head>

<body>
    <form action="forgot_pass.php" method="post">
    <div class="card" >
    <p class="lock-icon"><i class="fas fa-lock"></i></p>
        <h2>Forgot Password?</h2>
        <p>You can reset your Password here</p>
        <input type="text" name='Student_email' class="passInput" placeholder="Email address">
        <input type="submit" class="btn" value="Send Email">
   </div>
   </form>

</body>

</html>