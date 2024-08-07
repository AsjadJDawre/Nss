<?php
require_once('config.php'); // Include your database configuration
require('fpdf/fpdf.php');

// Default or initial data when the page loads
$tableData = [];

// Check if data is sent via GET request
function logMessage($message) {
    $logFile = 'C:\\xampp\\htdocs\\NSS\\Nss\\data_log.txt'; // Specify the path to your log file
    file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
}

// Check if data has been posted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['data'])) {
    // Log the received data
    logMessage('Received data: ' . $_POST['data']);

    // Retrieve and decode the posted data
    $tableData = json_decode(urldecode($_POST['data']), true);


        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AliasNbPages('{pages}');
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 9);

        if (!empty($tableData)) {
            $leftmargin=5;

            $pdf->SetFont('Arial', 'B', 9); // Bold font for headers
            $pdf->SetFillColor(0, 51, 85); // Background color for headers
            $pdf->SetTextColor(255); // Text color for headers

            $pdf->Cell(20, 5, 'Name', 1, 0, 'C',true,'',0,$leftmargin);
            $pdf->Cell(25, 5, 'Department', 1, 0, 'C',true,'',0,$leftmargin);
            $pdf->Cell(20, 5, 'Year', 1, 0, 'C',true,'',0,$leftmargin);
            $pdf->Cell(30, 5, 'Contact', 1, 0, 'C',true,'',0,$leftmargin);
            $pdf->Cell(40, 5, 'Address', 1, 0, 'C',true,'',0,$leftmargin);
            $pdf->Cell(20, 5, 'DOB', 1, 0, 'C',true,'',0,$leftmargin);
            $pdf->Cell(15, 5, 'Gender', 1, 0, 'C',true,'',0,$leftmargin);
            $pdf->Cell(28, 5, 'Category', 1, 0, 'C',true,'',0,$leftmargin);
            $pdf->Ln();
            
            $pdf->SetFont('Arial', '', 9); // Reset font to normal for data
$pdf->SetFillColor(255); // Reset background color
$pdf->SetTextColor(0); // Reset text color

            foreach ($tableData as $data) {
                $pdf->Cell(20, 10, $data['username'], 1, 0, 'C');
                $pdf->Cell(25, 10, $data['department'], 1, 0, 'C');
                $pdf->Cell(20, 10, $data['year'], 1, 0, 'C');
                $pdf->Cell(30, 10, $data['contact'], 1, 0, 'C');
            
                // Save current position
                $xPos = $pdf->GetX();
                $yPos = $pdf->GetY();
            
                // Output address as a MultiCell to measure its height
                $pdf->MultiCell(40, 5, $data['address'], 1, 'L');
            
                // Calculate the height of the address block
                $addressHeight = $pdf->GetY() - $yPos;
            
                // Reset position to next cell after address block
                $pdf->SetXY($xPos + 40, $yPos);
            
                // Output DOB and Gender cells first
                $pdf->Cell(20, $addressHeight, $data['dob'], 1, 0, 'C');
                $pdf->Cell(15, $addressHeight, $data['gender'], 1, 0, 'C');
            
                // Save current position for category
                $xPosCategory = $pdf->GetX();
                $yPosCategory = $pdf->GetY();
            
                // Output category as a MultiCell to measure its height
                $pdf->MultiCell(28, 5, $data['category'], 1, 'C');
            
                // Calculate the height of the category block
                $categoryHeight = $pdf->GetY() - $yPosCategory;
                
            
                // Adjust position for the next row based on the category block's height
                $pdf->SetXY($xPosCategory + 28, $yPosCategory);
                $pdf->Cell(28, $addressHeight, '', 0, 0, 'L');
                $pdf->Ln();
            }
            
            }
        }
        $pdf->Output('student_report.pdf', 'I'); // 'I' displays the PDF in the browser
        exit; // Stop further execution after PDF generation

        
?>