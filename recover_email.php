<?php
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
    // Get the entered OTP and new password from the form
    $enteredOTP = $_POST['otp_text'];
    $newPassword = $_POST['new_password'];

    // Check if session variables are set
    if (isset($_SESSION['reset_email'], $_SESSION['reset_otp'])) {
        // Retrieve stored email and OTP from the session
        $resetEmail = $_SESSION['reset_email'];
        $storedOTP = $_SESSION['reset_otp'];

        // Validate OTP
        if ($enteredOTP == $storedOTP) {
            // OTP is valid, update the password in the database
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE users SET password = '$hashedPassword', confirm_password = '$hashedPassword' WHERE student_email = '$resetEmail'";

            if ($conn->query($updateSql) === TRUE) {
                // Clear the OTP data in the database
                $updateotp = "UPDATE users SET otp = NULL WHERE student_email = '$resetEmail'";
                if ($conn->query($updateotp) === FALSE) {
                    echo "Error updating OTP: " . $conn->error;
                } else {
                    // Password updated successfully
                    header("Location: login.php");
                    exit();
                }
                // Destroy the session
                session_destroy();
            } else {
                echo "Error updating password: " . $conn->error;
            }
        } else {
            // Invalid OTP
            echo "Invalid OTP. Please try again.";
        }
    } else {
        // Session variables not set
        echo "Session variables not set. Please try the password reset process again.";
    }
}

// Close the database connection
$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Forgot Password</title>
    <link rel="icon" href="forgot_pass_fav_icon.png" type="image/png">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-12 col-md-8 col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="mb-4">
                            <h5>Forgot Password?</h5>
                            <p class="mb-2">Enter the OTP sent to your registered email ID to reset the password</p>
                        </div>
                        <form action="recover_email.php" method="post">
                            <div class="mb-3" >
                                <label for="otp_text" class="form-label">Enter OTP</label>
                                <input type="text" id="otp_text" class="form-control" name="otp_text" placeholder="Enter Your OTP" required="">
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Enter New Password</label>
                                <input type="password" id="new_password" class="form-control" name="new_password" placeholder="Enter Your New Password" required="">
                            </div>
                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>
                        </form>
                        <span>Don't have an account? <a href="Login.php">Sign Up</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
