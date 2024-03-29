<?php
require_once "config.php";

// Sample dummy data
$username = "JohnDoe";
$password = password_hash("password123", PASSWORD_DEFAULT);
$confirm_password = password_hash("password123", PASSWORD_DEFAULT);
$gender = "Male";
$category = "Student";
$address = "123 Main Street";
$dob = "1990-01-01";
$contact = "1234567890";
$father_name = "John Doe Sr.";
$surname = "Doe";
$rollno = "001";
$zip = "12345";
$city = "City";
$photo = "john_doe.jpg";
$department = "Computer Science";
$year = "First Year";
$title = "Mr.";
$student_email = "johndoe@example.com";
$hobbies = "Reading, Swimming";
$special_interest = "Programming";
$blood_group = "A+";
$height = "5'10\"";
$voter = "Yes";
$voter_id = "VOT123456";
$worked_in_nss = "Yes";
$toilet_attached = "Yes";
$parent_name = "Jane Doe";
$office_address = "456 Business Blvd";
$mother_name = "Jane Doe";
$parent_contact = "9876543210";
$relationship = "Parent";
$profession = "Engineer";
$parent_email = "johndoe@student.com";

$sql = "INSERT INTO users (username, password, confirm_password, gender, category, address, dob, contact, father_name, surname, rollno, zip, city, photo, department, year, title, student_email, hobbies, special_interest, blood_group, height, voter, voter_id, worked_in_nss, toilet_attached, parent_name, office_address, mother_name, parent_contact, relationship, profession, parent_email) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";


// Prepare an insert statement
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
  // ** Fix: Add two more placeholders to match the number of variables */
  mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssssssssssssss", $param_username, $param_password, $param_confirm_password, $param_gender, $param_category, $param_address, $param_dob, $param_contact, $param_father_name, $param_surname, $param_rollno, $param_zip, $param_city, $param_photo, $param_department, $param_year, $param_title, $param_student_email, $param_hobbies, $param_special_interest, $param_blood_group, $param_height, $param_voter, $param_voter_id, $param_worked_in_nss, $param_toilet_attached, $param_parent_name, $param_office_address, $param_mother_name, $param_parent_contact, $param_relationship, $param_profession, $param_parent_email);

  // Set parameters (no need to hash password again)
  $param_username = $username;
  $param_password = $password;
  $param_confirm_password = $confirm_password;
  $param_gender = $gender;
  $param_category = $category;
  $param_address = $address;
  $param_dob = $dob;
  $param_contact = $contact;
  $param_father_name = $father_name;
  $param_surname = $surname;
  $param_rollno = $rollno;
  $param_zip = $zip;
  $param_city = $city;
  $param_photo = $photo;
  $param_department = $department;
  $param_year = $year;
  $param_title = $title;
    $param_student_email = $student_email;
    $param_hobbies = $hobbies;
    $param_special_interest = $special_interest;
    $param_blood_group = $blood_group;
    $param_height = $height;
    $param_voter = $voter;
    $param_voter_id = $voter_id;
    $param_worked_in_nss = $worked_in_nss;
    $param_toilet_attached = $toilet_attached;
    $param_parent_name = $parent_name;
    $param_office_address = $office_address;
    $param_mother_name = $mother_name;
    $param_parent_contact = $parent_contact;
    $param_relationship = $relationship;
    $param_profession = $profession;
    $param_parent_email = $parent_email;

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect to login page
        header("location: Login.php");
    } else {
        echo "Something went wrong. Please try again later.";
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "SQL statement preparation failed: " . mysqli_error($conn); // Handle the preparation error
}

// Close connection
mysqli_close($conn);
?>
