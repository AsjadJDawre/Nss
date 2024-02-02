<?php

$server = "localhost";
$db = "login";
$pass = "";
$username = "root";

$conn = mysqli_connect($server, $username, $pass, $db);

// Check the connection
if (!$conn) {
    die('Error: Cannot connect to the database');
}
$student="ASJAD";
$tableName = 'users';
$query = "SELECT username, student_email, contact, parent_contact, department, year FROM $tableName WHERE username='$student'";


$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die('Error: Unable to fetch data from the database');
}

// Process the fetched data
while ($row = mysqli_fetch_assoc($result)) {
    // Access the data for each student
    $username = $row['username'];
    $studentEmail = $row['student_email'];
    $contact = $row['contact'];
    $parentContact = $row['parent_contact'];
    $department = $row['department'];
    $year = $row['year'];

    // Do something with the data, for example, print it
    echo "Username: $username, Email: $studentEmail, Contact: $contact, Parent Contact: $parentContact, Department: $department, Year: $year<br>";
}

// Close the database connection
mysqli_close($conn);
?>


<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Response Email</title>
</head>
<body>
  <p>Please click one of the buttons below:</p>
  <a href="http://localhost/Nss/handle-response.php?response=yes">Yes</a>
<a href="http://localhost/your_project_folder/handle-response.php?response=no">No</a>

</body>
</html>
