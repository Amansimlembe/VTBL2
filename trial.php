<?php
require 'vendor/autoload.php'; // Include Composer's autoload

use PhpOffice\PhpSpreadsheet\IOFactory;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vtbl_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start(); // Start session to store data

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['uploaded_file'])) {
    $file = $_FILES['uploaded_file'];
    $fileTmpPath = $file['tmp_name'];
    $fileName = $file['name'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = ['xlsx', 'xls', 'csv', 'pdf', 'docx'];

    // Validate file type
    if (!in_array($fileType, $allowedTypes)) {
        echo "Invalid file type. Please upload an Excel, PDF, or Word file.";
        exit;
    }

    // Initialize an array to store extracted data
    $dataToInsert = [];
    $hasErrors = false;

    try {
        // Process based on file type
        if ($fileType === 'xlsx' || $fileType === 'xls' || $fileType === 'csv') {
            // Handle Excel files
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            foreach ($sheetData as $index => $row) {
                // Skip header row
                if ($index === 1) continue;

                $auction_no = trim($row['A']);
                $warehouse = trim($row['B']);
                $mark = trim($row['C']);
                $grade = trim($row['D']);
                $manf_date = trim($row['E']);
                $certification = trim($row['F']);
                $invoice = trim($row['G']);
                $no_of_pkgs = trim($row['H']);
                $type = trim($row['I']);
                $net_weight = trim($row['J']);
                $nature = trim($row['K']);

                // Validate auction_no format
                if (!preg_match('/^\d{1,2}-\d{1,2}$/', $auction_no)) {
                    echo "Invalid auction number format in Excel (Row $index): $auction_no<br>";
                    $hasErrors = true;
                    continue; // Skip invalid rows
                }

                // Check for empty values
                if (empty($auction_no) || empty($warehouse) || empty($mark) || empty($grade) || empty($invoice) || empty($no_of_pkgs) || empty($type) || empty($net_weight) || empty($nature)) {
                    echo "Row $index contains empty fields. Please complete all fields.<br>";
                    $hasErrors = true;
                    continue;
                }

                // Format manf_date to 'YYYY-MM-DD'
                if ($manf_date) {
                    $dateObj = DateTime::createFromFormat('d/m/Y', $manf_date); // Assuming date format is 'd/m/Y'
                    if ($dateObj) {
                        $manf_date = $dateObj->format('Y-m-d');
                    }
                }

                $dataToInsert[] = compact('auction_no', 'warehouse', 'mark', 'grade', 'manf_date', 'certification', 'invoice', 'no_of_pkgs', 'type', 'net_weight', 'nature');
            }
        } elseif ($fileType === 'pdf') {
            // Handle PDF files
            $parser = new PdfParser();
            $pdf = $parser->parseFile($fileTmpPath);
            $text = $pdf->getText();

            $lines = explode("\n", $text);
            foreach ($lines as $index => $line) {
                $columns = preg_split('/\s+/', $line);
                $auction_no = trim($columns[0] ?? '');
                $warehouse = trim($columns[1] ?? '');
                $mark = trim($columns[2] ?? '');
                $grade = trim($columns[3] ?? '');
                $manf_date = trim($columns[4] ?? '');
                $certification = trim($columns[5] ?? '');
                $invoice = trim($columns[6] ?? '');
                $no_of_pkgs = trim($columns[7] ?? '');
                $type = trim($columns[8] ?? '');
                $net_weight = trim($columns[9] ?? '');
                $nature = trim($columns[10] ?? '');

                // Validate auction_no format
                if (!preg_match('/^\d{1,2}-\d{1,2}$/', $auction_no)) {
                    echo "Invalid auction number format in PDF (Line $index): $auction_no<br>";
                    $hasErrors = true;
                    continue; // Skip invalid rows
                }

                // Check for empty values
                if (empty($auction_no) || empty($warehouse) || empty($mark) || empty($grade) || empty($invoice) || empty($no_of_pkgs) || empty($type) || empty($net_weight) || empty($nature)) {
                    echo "Line $index contains empty fields in PDF. Please complete all fields.<br>";
                    $hasErrors = true;
                    continue;
                }

                // Format manf_date to 'YYYY-MM-DD'
                if ($manf_date) {
                    $dateObj = DateTime::createFromFormat('d/m/Y', $manf_date);
                    if ($dateObj) {
                        $manf_date = $dateObj->format('Y-m-d');
                    }
                }

                $dataToInsert[] = compact('auction_no', 'warehouse', 'mark', 'grade', 'manf_date', 'certification', 'invoice', 'no_of_pkgs', 'type', 'net_weight', 'nature');
            }
        } elseif ($fileType === 'docx') {
            // Handle Word files
            $wordReader = WordIOFactory::createReader('Word2007');
            $phpWord = $wordReader->load($fileTmpPath);

            $text = '';
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text .= $element->getText() . "\n";
                    }
                }
            }

            $lines = explode("\n", $text);
            foreach ($lines as $index => $line) {
                $columns = explode(",", $line);
                $auction_no = trim($columns[0] ?? '');
                $warehouse = trim($columns[1] ?? '');
                $mark = trim($columns[2] ?? '');
                $grade = trim($columns[3] ?? '');
                $manf_date = trim($columns[4] ?? '');
                $certification = trim($columns[5] ?? '');
                $invoice = trim($columns[6] ?? '');
                $no_of_pkgs = trim($columns[7] ?? '');
                $type = trim($columns[8] ?? '');
                $net_weight = trim($columns[9] ?? '');
                $nature = trim($columns[10] ?? '');

                // Validate auction_no format
                if (!preg_match('/^\d{1,2}-\d{1,2}$/', $auction_no)) {
                    echo "Invalid auction number format in Word (Line $index): $auction_no<br>";
                    $hasErrors = true;
                    continue; // Skip invalid rows
                }

                // Check for empty values
                if (empty($auction_no) || empty($warehouse) || empty($mark) || empty($grade) || empty($invoice) || empty($no_of_pkgs) || empty($type) || empty($net_weight) || empty($nature)) {
                    echo "Line $index contains empty fields in Word. Please complete all fields.<br>";
                    $hasErrors = true;
                    continue;
                }

                // Format manf_date to 'YYYY-MM-DD'
                if ($manf_date) {
                    $dateObj = DateTime::createFromFormat('d/m/Y', $manf_date);
                    if ($dateObj) {
                        $manf_date = $dateObj->format('Y-m-d');
                    }
                }

                $dataToInsert[] = compact('auction_no', 'warehouse', 'mark', 'grade', 'manf_date', 'certification', 'invoice', 'no_of_pkgs', 'type', 'net_weight', 'nature');
            }
        }

        // If there are no errors, store data in the session for further processing
        if (!$hasErrors) {
            $_SESSION['dataToInsert'] = $dataToInsert;
        } else {
            echo "Please fix the errors and re-upload the file.";
            exit;
        }

    } catch (Exception $e) {
        echo "Error processing file: " . $e->getMessage();
        exit;
    }
}

// Handle form submission to insert data
if (isset($_POST['submit_data']) && isset($_SESSION['dataToInsert'])) {
    foreach ($_SESSION['dataToInsert'] as $data) {
        $query = "INSERT INTO user_inputs (auction_no, warehouse, mark, grade, manf_date, certification, invoice, no_of_pkgs, type, net_weight, nature)
                  VALUES ('{$data['auction_no']}', '{$data['warehouse']}', '{$data['mark']}', '{$data['grade']}', '{$data['manf_date']}', '{$data['certification']}', '{$data['invoice']}', '{$data['no_of_pkgs']}', '{$data['type']}', '{$data['net_weight']}', '{$data['nature']}')";

        if (!$conn->query($query)) {
            echo "Error inserting data: " . $conn->error;
            exit;
        }
    }

    echo "Data inserted successfully.";
    unset($_SESSION['dataToInsert']); // Clear session data
}

$conn->close();
?>


<script>
// Ensure that alert disappears after the user clicks "OK"
window.onload = function() {
    <?php if (isset($_GET['error'])) { ?>
        alert('<?php echo $_GET['error']; ?>');
    <?php } ?>
};
</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
</head>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File</title>
    <style>
         body {
        font-family: Arial, sans-serif;
        padding: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse; /* Makes the table borders collapse into one */
        table-layout: fixed; /* Ensures that table columns are evenly distributed */
    }

    th, td {
        border: 1px solid #ddd;
        text-align: left;
        padding: 8px;
        font-size: 12px; /* Decreased font size for responsiveness */
        word-wrap: break-word; /* Ensures content doesn't overflow */
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    td input {
        width: 100%; /* Ensures inputs fill the cell */
        padding: 5px;
        font-size: 12px; /* Ensures form inputs also have smaller text */
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    /* For responsiveness: Decrease font-size on smaller screens */
    @media (max-width: 768px) {
        th, td {
            font-size: 10px; /* Even smaller font size for mobile */
        }
    }

    /* Style for form and inputs */
    form {
        max-width: 1200px;
        margin: 0 auto;
        overflow-x: auto; /* Allow horizontal scroll if needed */
    }
        .table-container {
            position: relative;
            margin-top: 20px;
            display: none; /* Initially hidden */
        }
        .close-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            font-size: 16px;
            cursor: pointer;
            line-height: 20px;
            text-align: center;
        }
        .close-btn:hover {
            background-color: darkred;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h2>Upload an Excel, PDF, or Word File</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="uploaded_file" required>
        <button type="submit">Upload</button>
    </form>

    <div class="table-container" id="data-table">
        <button class="close-btn">X</button>
        <form action="" method="POST">
            <table>
                <tr>
                    <th>Auction No</th>
                    <th>Warehouse</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Manf Date</th>
                    <th>Certification</th>
                    <th>Invoice</th>
                    <th>No of Packages</th>
                    <th>Type</th>
                    <th>Net Weight</th>
                    <th>Nature</th>
                </tr>

                <?php
                if (isset($_SESSION['dataToInsert'])) {
                    foreach ($_SESSION['dataToInsert'] as $index => $row) {
                        echo "<tr>";
                        echo "<td><input type='text' name='auction_no[$index]' value='{$row['auction_no']}'></td>";
                        echo "<td><input type='text' name='warehouse[$index]' value='{$row['warehouse']}'></td>";
                        echo "<td><input type='text' name='mark[$index]' value='{$row['mark']}'></td>";
                        echo "<td><input type='text' name='grade[$index]' value='{$row['grade']}'></td>";
                        echo "<td><input type='text' name='manf_date[$index]' value='{$row['manf_date']}'></td>";
                        echo "<td><input type='text' name='certification[$index]' value='{$row['certification']}'></td>";
                        echo "<td><input type='text' name='invoice[$index]' value='{$row['invoice']}'></td>";
                        echo "<td><input type='text' name='no_of_pkgs[$index]' value='{$row['no_of_pkgs']}'></td>";
                        echo "<td><input type='text' name='type[$index]' value='{$row['type']}'></td>";
                        echo "<td><input type='text' name='net_weight[$index]' value='{$row['net_weight']}'></td>";
                        echo "<td><input type='text' name='nature[$index]' value='{$row['nature']}'></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
            <input type="submit" name="submit_edit" value="Submit Changes">
        </form>
    </div>

    <script>
        $(document).ready(function () {
            // Show the table if data exists in PHP session
            <?php if (isset($_SESSION['dataToInsert']) && count($_SESSION['dataToInsert']) > 0): ?>
                $("#data-table").show();
            <?php endif; ?>

            // Close table when close button is clicked
            $(".close-btn").click(function () {
                $(".table-container").hide();
            });
        });
    </script>
</body>
</html>
 