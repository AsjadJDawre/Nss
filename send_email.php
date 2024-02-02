<?php

// Email configuration
$to = 'dawreasjad72@example.com';
$subject = 'Test Email with Buttons';
$message = file_get_contents('reponse_email.php');

// Set the headers for HTML content
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Additional headers
$headers .= 'From: projecttesting48@gmail.com.com' . "\r\n"; // Replace with your email address

// Send the email
mail($to, $subject, $message, $headers);

echo 'Email sent successfully';
?>
