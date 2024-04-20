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
    // Get the entered OTP from the form
    $enteredOTP = $_POST['otp_text'];

    // Fetch the OTP and admin email associated with the admin username "ADMIN"
    $query = "SELECT admin_email, otp FROM admin WHERE username = 'ADMIN'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $storedOTP = $row['otp'];
        $adminEmail = $row['admin_email'];

        // Check if the entered OTP matches the stored OTP
        if ($enteredOTP == $storedOTP) {
            // Clear the OTP value in the database
            $clearOTPQuery = "UPDATE admin SET otp = NULL WHERE username = 'ADMIN'";
            if ($conn->query($clearOTPQuery) === TRUE) {
                // Redirect to new_admin.php
                header("Location: new_admin.php?admin_email=$adminEmail");
                exit();
            } else {
                echo "Error clearing OTP: " . $conn->error;
            }
        } else {
            echo "Invalid OTP. Please try again.";
        }
    } else {
        echo "Admin not found.";
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
    <title> Verify  Password</title>
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
                            <h5>Verification</h5>
                            <p class="mb-2">Enter the verification code  sent to your registered email ID </p>
                        </div>
                        <form action="verify_admin.php" method="post">
                            <div class="mb-3" >
                                <label for="otp_text" class="form-label">Enter Code</label>
                                <input type="text" id="otp_text" class="form-control" name="otp_text" placeholder="Enter Your OTP" required="">
                            </div>
                           
                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Verify  Code
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
