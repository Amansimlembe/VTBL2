<?php
// Include Composer's autoload file
require 'vendor/autoload.php';  // Make sure Composer's autoload.php is included

// Use the necessary PhpSpreadsheet and PHPMailer classes
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if a file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Check for file type (Excel or PDF)
    $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);

    if ($fileType == 'xlsx' || $fileType == 'xls') {
        // Excel file: Use PhpSpreadsheet to extract data
        try {
            $spreadsheet = IOFactory::load($file['tmp_name']);
            $sheet = $spreadsheet->getActiveSheet();

            // Process the Excel data
            $data = [];
            foreach ($sheet->getRowIterator() as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getFormattedValue();
                }
                $data[] = $rowData;
            }

            // Build the email content with the extracted data
            $emailContent = "Auction Data Extracted:<br><br>";
            foreach ($data as $row) {
                $emailContent .= "<b>Auction No:</b> " . $row[0] . "<br>";
                $emailContent .= "<b>Comments:</b> " . $row[1] . "<br>";
                $emailContent .= "<b>Warehouse:</b> " . $row[2] . "<br>";
                $emailContent .= "<b>Value:</b> " . $row[3] . "<br>";
                $emailContent .= "<b>Mark:</b> " . $row[4] . "<br>";
                $emailContent .= "<b>Grade:</b> " . $row[5] . "<br>";
                $emailContent .= "<b>Manufacturing Date:</b> " . $row[6] . "<br>";
                $emailContent .= "<b>Certification:</b> " . $row[7] . "<br>";
                $emailContent .= "<b>Invoice:</b> " . $row[8] . "<br>";
                $emailContent .= "<b>Number of Packages:</b> " . $row[9] . "<br>";
                $emailContent .= "<b>Type:</b> " . $row[10] . "<br>";
                $emailContent .= "<b>Net Weight:</b> " . $row[11] . "<br>";
                $emailContent .= "<b>Nature:</b> " . $row[12] . "<br>";
                $emailContent .= "<b>Sale Price:</b> " . $row[13] . "<br>";
                $emailContent .= "<b>Buyer Packages:</b> " . $row[14] . "<br><br>";
            }

            // Send the email with PHPMailer
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.yourdomain.com';  // Update with your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'your_email@example.com';
                $mail->Password = 'your_password';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('your_email@example.com', 'Auction Data');
                $mail->addAddress('recipient@example.com');  // Add recipient email

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Auction Data Extracted';
                $mail->Body    = $emailContent;

                $mail->send();
                echo 'Auction data has been sent via email.';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        } catch (Exception $e) {
            echo 'Error loading the Excel file: ', $e->getMessage();
        }
    } else {
        echo "Invalid file type. Please upload an Excel file.";
    }
}
?>
