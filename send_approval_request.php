<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Decode JSON data from the request
    $data = json_decode(file_get_contents("php://input"));

    // Get user information
    $username = $data->username;
    $contactNumber = $data->contact;
    $studentEmail ="dummy234@emailaddress";

    // Construct the message to be sent to the admin
    $message = "User $username wants to edit their profile. Contact Number: $contactNumber, Student Email: $studentEmail";

    // Admin email address (replace with your admin's email)
    $adminEmail = "admin_email.com";

    // Subject of the email
    $subject = "Profile Edit Request";

    // HTML content for the email body
    $emailBody = "
        <p>$message</p>
        <p>Do you approve this request?</p>
        <a href='student.php?username=$username&response=Approved'>Approve</a>
        <a href='student.php?username=$username&response=Rejected'>Reject</a>
    ";

    // Additional headers for HTML emails
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

    // Send the email
    mail($adminEmail, $subject, $emailBody, $headers);

    // For demonstration purposes, just echo the message
    echo $message;
} else {
    // Handle invalid requests
    http_response_code(400);
    echo "Invalid request method";
}
?>
