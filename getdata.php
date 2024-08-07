<?php
// Retrieve form data from POST
$username = isset($_POST['username']) ? $_POST['username'] : '';
$department = isset($_POST['department']) ? $_POST['department'] : '';
// ... (other form fields)

// Debugging: Write form data to a log file
$logFile = 'data_log.txt';
$logData = "Received form data:\n" . print_r($_POST, true) . "\n\n"; // Format the data

// Check if the log file exists
if (file_exists($logFile)) {
    // Append the received data to the existing log file
    file_put_contents($logFile, $logData);
} else {
    // Create a new log file and add the content
    file_put_contents($logFile, $logData);
}

$current_year = date('Y');

// Calculate the next year
$next_year = $current_year + 1;

// Combine both years into a single string
$year_range = $current_year . '-' . $next_year;





require('fpdf/fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage('P', 'A4');
    
    $pdf->SetFont('Arial', 'U', 16);
    $pdf->Cell(0, 10, 'Proforma  II  Enrollment Form for the NSS Volunteers', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12); // Set the font size for the additional line
    $pdf->Cell(0, 5, 'Application for Admission to NSS for the year 20____- 20 ___', 0, 1, 'C');
    
    $pdf->SetFont('Arial', '', 12); // Set the font size for the "Sr. No.:- __________" text
    $pdf->Cell(0, 10, 'Sr. No.:- __________', 0, 0, 'L'); // Add the left-aligned text
    
    
    
    // Add "Year of Enrollment in NSS (Pl. tick) : I / II" on the right side
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Year of Enrollment in NSS (Pl. tick) : I / II', 0, 1, 'R');
    
    $pdf->SetFont('Arial', '', 15);
    $pdf->Cell(0, 10, 'NATIONAL SERVICE SCHEME', 0, 1, 'C');
    
    
    
    // Draw the photo box
    $photoBoxX = 165; // X-coordinate for the photo box
    $photoBoxY = $pdf->GetY(); // Y-coordinate aligned with "The Programme Officer" text
    $photoBoxWidth = 35; // Width of the photo box
    $photoBoxHeight = 45; // Height of the photo box
    
    $pdf->Rect($photoBoxX, $photoBoxY, $photoBoxWidth, $photoBoxHeight);
    
/// Construct the image file path based on the username
$imageFilename = 'C:\\xampp\\htdocs\\Nss\\Nss\\images' . DIRECTORY_SEPARATOR . $username . '.png'; // You can adjust the extension based on your actual image format

// Check if the image file exists before adding it to the PDF
if (file_exists($imageFilename)) {
    // Load and display the user's image in the photo box
    $pdf->Image($imageFilename, $photoBoxX, $photoBoxY, $photoBoxWidth, $photoBoxHeight);
} else {
    // If the image doesn't exist, display a placeholder image:
    $pdf->Image('C:\\xampp\\htdocs\\Nss\\images\\placeholder.jpg', $photoBoxX, $photoBoxY, $photoBoxWidth, $photoBoxHeight);
}



    
    // Your variable assignments
    $username = isset($_POST['username']) ? $_POST['username'] : '';
    $department = isset($_POST['department']) ? $_POST['department'] : '';
    $year = isset($_POST['year']) ? $_POST['year'] : '';
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $dob = isset($_POST['dob']) ? $_POST['dob'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
    $zip = isset($_POST['zip']) ? $_POST['zip'] : '';
    $rollno = isset($_POST['rollno']) ? $_POST['rollno'] : '';
    $father_name = isset($_POST['father_name']) ? $_POST['father_name'] : '';
    $surname = isset($_POST['surname']) ? $_POST['surname'] : '';
    $mother_name = isset($_POST['mother_name']) ? $_POST['mother_name'] : '';
    $email = isset($_POST['student_email']) ? $_POST['student_email'] : '';
    $hobbies = isset($_POST['hobbies']) ? $_POST['hobbies'] : '';
    $special_interest = isset($_POST['special_interest']) ? $_POST['special_interest'] : '';
    $blood_group = isset($_POST['blood_group']) ? $_POST['blood_group'] : '';
    $height = isset($_POST['height']) ? $_POST['height'] : '';
    $voter = isset($_POST['voter']) ? $_POST['voter'] : '';
    $voter_id = isset($_POST['voter_id']) ? $_POST['voter_id'] : '';
    $worked_in_nss = isset($_POST['worked_in_nss']) ? $_POST['worked_in_nss'] : '';
    $toilet_attached = isset($_POST['toilet_attached']) ? $_POST['toilet_attached'] : '';
    $parent_name = isset($_POST['parent_name']) ? $_POST['parent_name'] : '';
    $office_address = isset($_POST['office_address']) ? $_POST['office_address'] : '';
    $parent_contact = isset($_POST['parent_contact']) ? $_POST['parent_contact'] : '';
    $relationship = isset($_POST['relationship']) ? $_POST['relationship'] : '';
    $profession = isset($_POST['profession']) ? $_POST['profession'] : '';
    
    
    // Add the text "To, The Programme Officer, NSS Unit," to the left side of "National Service Scheme"
    $leftText = "To,\nThe Programme Officer, NSS Unit,\n______________________________\n______________________________\n______________________________";
    $pdf->MultiCell(0, 10, $leftText, 0, 'L');
    
    
    
    
    
    // Prepare the text with proper concatenation
    $pdf->SetFont('Arial', '', 10); // Use Arial font, size 12
    $text = "\nSir,\nI Mr./Ms. $surname $username $father_name $mother_name of class (in Capital letters and Surname, Name, Father's and Mother's Name to be mentioned) Division $department Roll No. $rollno\nwish to participate in NSS activities for the year $year_range.\nI shall abide by all rules and regulations of NSS Programme / Special Camps and participate in the NSS Regular Programme / Special Camps conducted by College/University at own risk. I further undertake to complete 120 hours of work in Regular Programme and at least one Special Camp of Seven days, during this year / next year. (A student who was a volunteer of NSS in the previous year and has not attended Special Camp can enroll only if he/she undertakes to participate in Special Camp in this year.)";

    
    // Set the position and output the text
    $pdf->SetX(10);
    $pdf->MultiCell(0, 10, utf8_decode($text), 0, 'L');
    
    
    $date = date("d/m/Y");  // Example format: 01/03/2024
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 20, "Date: $date", 0, 1, 'L');
    
    
    // Add space for the student's signature
    $pdf->Cell(0, 20, "Signature of the Student,", 0, 0, 'R'); // Note: Changed the X-coordinate from 0 to 10
    
    // Add some space between the text and the line
    // $pdf->Cell(10); // Add space of 10 units
    
    // Get the current Y-coordinate and increase it by 17 (or any other necessary spacing)
    $yPosition = $pdf->GetY() + 17;
    
    // Set the line width
    $pdf->SetLineWidth(0.5);  // Adjust the line width as needed
    
    // Set the position for the starting point of the line (below the sentence)
    $startX = 10;   // X-coordinate of the starting point
    $startY = $yPosition + 5;  // Y-coordinate of the starting point (add some space below the text)
    
    // Set the position for the ending point of the line (extend to the right edge of the page)
    $endX = $pdf->GetPageWidth() - 10;  // X-coordinate of the ending point (page width minus margin)
    $endY = $yPosition + 5;  // Y-coordinate of the ending point (keep it at the same level)
    
    // Draw the horizontal line below the text, spanning the full page width
    $pdf->Line($startX, $startY, $endX, $endY);
    
    // Get the current page width
    $pageWidth = $pdf->GetPageWidth();
    
    // Calculate the X-coordinate to center the text
    $textWidth = $pdf->GetStringWidth("PERSONAL DATA OF STUDENT (ALL BLOCK LETTERS)");
    $xCoordinate = ($pageWidth - $textWidth) / 2 - 17; // Adjusted for more left alignment
    
    // Set the X-coordinate and center the text
    // Add a new page
$pdf->AddPage();
    $pdf->Line($startX, $startY, $endX, $endY);


    $startX = $pdf->GetX();

    // Print the text "PERSONAL DATA OF STUDENT (ALL BLOCK LETTERS)" centered
    $pdf->Cell(0, 10, "PERSONAL DATA OF STUDENT (ALL BLOCK LETTERS)", 0, 1, 'C');
    
    // Determine the ending X position
    $endX = $pdf->GetX();
    
    // Draw the line under the text
    $pdf->Line($startX, $pdf->GetY(), $endX, $pdf->GetY());
    
    
    // Add Local Address
    $pdf->Cell(0, 2, "1. Local Address:". $address, 0, 1, 'L');
    $pdf->Cell(0, 8, "    Ward:    ", 0, 1, 'L');
    $pdf->Cell(0, 8, "    Contact No. (Mobile):     " . $contact, 0, 1, 'L');
    $pdf->Cell(0, 9, "    Email Id. :    " . $email, 0, 1, 'L');
    
    // Add Hobbies/Interest
    $pdf->MultiCell(0, 5, "2. Hobbies/Interest:    " . $hobbies, 0, 'L');
    
    // Add Special Interest
    $pdf->MultiCell(0, 5, "3. Special Interest:    " . $special_interest, 0, 'L');
    
    // Add Blood Group
    $pdf->MultiCell(0, 5, "4. Blood Group:     " . $blood_group, 0, 'L');
    
    // Add Height
    $pdf->MultiCell(0, 5, "5. Height: " . $height, 0, 'L');
    
    // Add Date of Birth
    $pdf->MultiCell(0, 5, "6. Date of Birth:    " . $dob, 0, 'L');
    
    // Add Enrolled as Voter
    $pdf->Cell(0, 10, "7. Enrolled as Voter:    " . $voter, 0, 1, 'L');
    $pdf->Cell(0, 6, "  If Yes Pl State Voter Id:    " . $voter_id, 0, 1, 'L');
    
    // Add Caste
    $pdf->MultiCell(0, 5, "8. Caste: " . $category, 0, 'L');
    
    // Add Worked in NSS/NCC/MCC
    $pdf->MultiCell(0, 5, "9. Have you worked in NSS/NCC/MCC/Scout/Guide/Other- Pl specify: " . $worked_in_nss, 0, 'L');
    
    // Add Toilet Attached
    $pdf->Cell(0, 10, "10. Toilet attached to your house YES/NO-  " . $toilet_attached, 0, 1, 'L');
    $pdf->Cell(0, 8, "If No, commitment to construct Toilet within a year." . $toilet_attached, 0, 1, 'L');
    
    
    
    // Get the current Y-coordinate and increase it by 17 (or any other necessary spacing)
    $yPosition = $pdf->GetY() - 5;
    
    // Set the line width
    $pdf->SetLineWidth(0.5);  // Adjust the line width as needed
    
    // Set the position for the starting point of the line (below the sentence)
    $startX = 10;   // X-coordinate of the starting point
    $startY = $yPosition + 5;  // Y-coordinate of the starting point (add some space below the text)
    
    // Set the position for the ending point of the line (extend to the right edge of the page)
    $endX = $pdf->GetPageWidth() - 10;  // X-coordinate of the ending point (page width minus margin)
    $endY = $yPosition + 5;  // Y-coordinate of the ending point (keep it at the same level)
    
    // Draw the horizontal line below the text, spanning the full page width
    $pdf->Line($startX, $startY, $endX, $endY);
    
    
    // Add the provided text with the star symbol (✳)
    $pdf->SetFont('Arial', '', 10); // You can adjust the font and size as needed
    
    $pdf->Cell(0, 7, " Fresh T.Y. Students cannot enroll as; this scheme is designed for two years. Students of T.Y. Classes can enroll for NSS,", 0, 1, 'L'); // Reduced spacing to 7
    $pdf->Cell(0, 7, "only if he/she has completed at least 120 hours of Social Work in the previous year.", 0, 1, 'L'); // Reduced spacing to 7
    
    $pdf->Cell(0, 6, "Have you completed 120 hours in Regular NSS? YES/NO, if yes, Year ______________ Class ______________", 0, 1, 'L');
    $pdf->Cell(0, 7, "Have you attended 07 days Special Camp? YES/NO, if yes, Year _____________ Class ____________", 0, 1, 'L');
    
    // Get the current Y-coordinate and increase it by 17 (or any other necessary spacing)
    $yPosition = $pdf->GetY() +0.51;
    
    // Set the line width
    $pdf->SetLineWidth(0.5);  // Adjust the line width as needed
    
    // Set the position for the starting point of the line (below the sentence)
    $startX = 10;   // X-coordinate of the starting point
    $startY = $yPosition + 5;  // Y-coordinate of the starting point (add some space below the text)
    
    // Set the position for the ending point of the line (extend to the right edge of the page)
    $endX = $pdf->GetPageWidth() - 10;  // X-coordinate of the ending point (page width minus margin)
    $endY = $yPosition + 5;  // Y-coordinate of the ending point (keep it at the same level)
    
    // Draw the horizontal line below the text, spanning the full page width
    $pdf->Line($startX, $startY, $endX, $endY);
    
    
    $pdf->SetFont('Arial', 'B', 12); // You can adjust the font and size as needed
    
    $pdf->Cell(0, 16, "FOR OFFICE USE ONLY:", 0, 1, 'L'); // Reduced spacing to 12
    
    $pdf->SetFont('Arial', '', 10); // You can adjust the font and size as needed
    
    $pdf->Cell(0, 6, "Application received date : __________", 0, 1, 'L'); // Reduced spacing to 6
    $pdf->Cell(0, 6, "Whether accepted as NSS Volunteer : YES / NO", 0, 1, 'L'); // Reduced spacing to 6
    $pdf->Cell(0, 6, "If Yes, received NSS Registration Fee of Rs. 10/- : YES / NO", 0, 1, 'L'); // Reduced spacing to 6
    $pdf->Cell(0, 6, "Allocated Volunteer Enrolment Code Number (V.E.C.) : MH09 __ __ __ __ __ __ __ __ __", 0, 1, 'L'); // Reduced spacing to 6
    
    $pdf->Ln(8); 
    $pdf->SetFont('Arial', '', 12); // You can adjust the font and size as needed
    
    $pdf->MultiCell(0, 8, "Name of Unit Incharge NSS Programme Officer", 0, 'L');
    $pdf->MultiCell(0, 10, "_______________________________________", 0, 'L'); // Line for the name
    
    $pdf->Cell(100); // Add space to move to the right side for the signature
    
    $pdf->Cell(0, -35, "Signature", 0, 'R');
    // Add some space for the signature
    $pdf->Cell(0, 60, "_______________________________________", 0, 'R'); // Line for the signature
    
    // Get the current Y-coordinate and increase it by 17 (or any other necessary spacing)
    $yPosition = $pdf->GetY() -29;
    
    // Set the line width
    $pdf->SetLineWidth(0.5);  // Adjust the line width as needed
    
    // Set the position for the starting point of the line (below the sentence)
    $startX = 10;   // X-coordinate of the starting point
    $startY = $yPosition + 5;  // Y-coordinate of the starting point (add some space below the text)
    
    // Set the position for the ending point of the line (extend to the right edge of the page)
    $endX = $pdf->GetPageWidth() - 10;  // X-coordinate of the ending point (page width minus margin)
    $endY = $yPosition + 5;  // Y-coordinate of the ending point (keep it at the same level)
    
    // Draw the horizontal line below the text, spanning the full page width
    $pdf->Line($startX, $startY, $endX, $endY);
    
    
    $pdf->SetFont('Arial', 'U', 10); // You can adjust the font and size as needed
    
    // Define the width of the text area
    $textWidth = $pdf->GetStringWidth("THIS APPLICATION FORM IS NOT FOR SALE, ENROLLED STUDENT SHOULD PAY REGISTRATION FEES RS. 10/- ONLY");
    
    // Calculate the X-coordinate to center the text
    $xCoordinate = ($pdf->GetPageWidth() - $textWidth) / 2;
    
    // Set the X-coordinate and center the text
    $pdf->SetX($xCoordinate);
    $pdf->Cell(0, -40, "THIS APPLICATION FORM IS NOT FOR SALE, ENROLLED STUDENT SHOULD PAY REGISTRATION FEES RS. 10/- ONLY", 0, 'L');

    $filename = $username .'_Nss_form.pdf';

    // Set the appropriate headers for download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    // Output the PDF to the browser for download
    $pdf->Output($filename,'D');
  

?>