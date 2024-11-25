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

$allowedMarks = [
    'Chivanjee', 'kibena', 'Itona', 'Ikanga', 'Kiganga', 'Kibwele', 'Lugoda', 
    'Kilima', 'kabambe', 'Luponde', 'Lupembe', 'Katumba', 'Mwakaleli', 'Livingstonia', 
    'Arc mountain', 'Dindira', 'Kwamkoro', 'Mponde', 'Kagera'
];

$allowedGrades = [
    'BP1', 'PF1', 'PD', 'D1', 'BP', 'PF', 'D2', 
    'DUST', 'FNGS', 'BMF', 'Orthodox'
];

$allowedNatures = [
    'Fresh', 'Reprint'
];

$allowedWarehouses = [
    'Bravo', 'EUTEACO'
];
$allowedTyp = [
    'TPP', 'PB'
];

$allowedCertifications = [
    'Non RA', 'RA'
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['uploaded_file'])) {
    $file = $_FILES['uploaded_file'];
    $fileTmpPath = $file['tmp_name'];
    $fileName = $file['name'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = ['xlsx', 'xls', 'csv', 'pdf', 'docx'];

    // Validate file type
    if (!in_array($fileType, $allowedTypes)) {
        echo "<script>alert('Invalid file type. Please upload an Excel, PDF, or Word file.');</script>";
        exit;
    }

    // Initialize an array to store extracted data
    $dataToInsert = [];

    try {
        // Process based on file type
        if ($fileType === 'xlsx' || $fileType === 'xls' || $fileType === 'csv') {
            // Handle Excel files
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            foreach ($sheetData as $row) {
                
                $auction_no = trim($row['A']);
                if (strlen($auction_no) >= 3) {
                    // If auction_no has no dash, format it as "XX-XX" or "XXX-XX"
                    if (strpos($auction_no, '-') === false) {
                        $auction_no = substr($auction_no, 0, -2) . '-' . substr($auction_no, -2);
                    }
                    // Ensure auction_no has the correct format (XX-XX or XXX-XX)
                    if (!preg_match('/^\d{1,2}-\d{2}$/', $auction_no)) {
                        continue; // Skip rows with incorrect auction_no format
                    }
                } else {
                    continue; // Skip rows with auction_no less than 3 digits
                }


                // Validate mark
                $mark = trim($row['C']);
                if (!in_array($mark, $allowedMarks)) {
                    continue; // Skip rows with invalid mark
                }

                  // Validate mark
                  $grade = trim($row['D']);
                  if (!in_array($grade, $allowedGrades)) {
                      continue; // Skip rows with invalid mark
                  }

                    // Validate mark
                    $warehouse = trim($row['B']);
                    if (!in_array($warehouse, $allowedWarehouses)) {
                        continue; // Skip rows with invalid mark
                    }
                      // Validate mark
                  $certification = trim($row['F']);
                  if (!in_array($certification, $allowedCertifications)) {
                      continue; // Skip rows with invalid mark
                  }

                    // Validate mark
                    $type = trim($row['I']);
                    if (!in_array($type, $allowedTyp)) {
                        continue; // Skip rows with invalid mark
                    }

                      // Validate mark
                  $nature = trim($row['K']);
                  if (!in_array($nature, $allowedNatures)) {
                      continue; // Skip rows with invalid mark
                  }

                // Format manf_date to 'YYYY-MM-DD'
                $manf_date = trim($row['E']);
                if ($manf_date) {
                    $dateObj = DateTime::createFromFormat('d/m/Y', $manf_date); // Assuming date format from Excel is 'd/m/Y'
                    if ($dateObj) {
                        $manf_date = $dateObj->format('Y-m-d'); // Convert to 'YYYY-MM-DD'
                    }
                }

                $dataToInsert[] = [
                    'auction_no' => $auction_no,
                    'warehouse' => trim($row['B']),
                    'mark' => $mark,
                    'grade' => trim($row['D']),
                    'manf_date' => $manf_date, // Store the formatted date
                    'certification' => trim($row['F']),
                    'invoice' => trim($row['G']),
                    'no_of_pkgs' => trim($row['H']),
                    'type' => trim($row['I']),
                    'net_weight' => trim($row['J']),
                    'nature' => trim($row['K'])
                ];
            }
        } elseif ($fileType === 'pdf') {
            // Handle PDF files
            $parser = new PdfParser();
            $pdf = $parser->parseFile($fileTmpPath);
            $text = $pdf->getText();

            $lines = explode("\n", $text);
            foreach ($lines as $line) {
                if (strpos($line, 'auction_no') !== false) {
                    continue;
                }

                $columns = preg_split('/\s+/', $line); 

                $auction_no = isset($columns[0]) ? trim($columns[0]) : '';
                if (strlen($auction_no) >= 3) {
                    // If auction_no has no dash, format it as "XX-XX" or "XXX-XX"
                    if (strpos($auction_no, '-') === false) {
                        $auction_no = substr($auction_no, 0, -2) . '-' . substr($auction_no, -2);
                    }
                    // Ensure auction_no has the correct format (XX-XX or XXX-XX)
                    if (!preg_match('/^\d{1,2}-\d{2}$/', $auction_no)) {
                        continue; // Skip rows with incorrect auction_no format
                    }
                } else {
                    continue; // Skip rows with auction_no less than 3 digits
                }

                 // Validate mark
                 $mark = isset($columns[2]) ? trim($columns[2]) : '';
                 if (!in_array($mark, $allowedMarks)) {
                     continue; // Skip rows with invalid mark
                 }

                   // Validate mark
                   $grade = isset($columns[3]) ? trim($columns[3]) : '';
                   if (!in_array($grade, $allowedGrades)) {
                       continue; // Skip rows with invalid mark
                   }

                     // Validate mark
                 $warehouse = isset($columns[1]) ? trim($columns[1]) : '';
                 if (!in_array($warehouse, $allowedWarehouses)) {
                     continue; // Skip rows with invalid mark
                 }

                   // Validate mark
                   $type = isset($columns[8]) ? trim($columns[8]) : '';
                   if (!in_array($type, $allowedTyp)) {
                       continue; // Skip rows with invalid mark
                   }

                     // Validate mark
                 $nature = isset($columns[10]) ? trim($columns[10]) : '';
                 if (!in_array($nature, $allowedNatures)) {
                     continue; // Skip rows with invalid mark
                 }

                $manf_date = isset($columns[4]) ? trim($columns[4]) : '';
                if ($manf_date) {
                    $dateObj = DateTime::createFromFormat('d/m/Y', $manf_date);
                    if ($dateObj) {
                        $manf_date = $dateObj->format('Y-m-d');
                    }
                }

                $dataToInsert[] = [
                    'auction_no' => $auction_no,
                    'warehouse' => isset($columns[1]) ? trim($columns[1]) : '',
                    'mark' => $mark,
                    'grade' => isset($columns[3]) ? trim($columns[3]) : '',
                    'manf_date' => $manf_date,
                    'certification' => isset($columns[5]) ? trim($columns[5]) : '',
                    'invoice' => isset($columns[6]) ? trim($columns[6]) : '',
                    'no_of_pkgs' => isset($columns[7]) ? trim($columns[7]) : '',
                    'type' => isset($columns[8]) ? trim($columns[8]) : '',
                    'net_weight' => isset($columns[9]) ? trim($columns[9]) : '',
                    'nature' => isset($columns[10]) ? trim($columns[10]) : ''
                ];
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
            foreach ($lines as $line) {
                $columns = explode(",", $line);
                $auction_no = isset($columns[0]) ? trim($columns[0]) : '';
                if (strlen($auction_no) >= 3) {
                    if (strpos($auction_no, '-') === false) {
                        $auction_no = substr($auction_no, 0, -2) . '-' . substr($auction_no, -2);
                    }
                    if (!preg_match('/^\d{1,2}-\d{2}$/', $auction_no)) {
                        continue;
                    }
                } else {
                    continue;
                }

                 // Validate mark
                 $mark = isset($columns[2]) ? trim($columns[2]) : '';
                 if (!in_array($mark, $allowedMarks)) {
                     continue; // Skip rows with invalid mark
                 }
 
  // Validate mark
  $grade = isset($columns[3]) ? trim($columns[3]) : '';
  if (!in_array($grade, $allowedGrades)) {
      continue; // Skip rows with invalid mark
  }

    // Validate mark
$warehouse = isset($columns[1]) ? trim($columns[1]) : '';
if (!in_array($warehouse, $allowedWarehouses)) {
    continue; // Skip rows with invalid mark
}

  // Validate mark
  $type = isset($columns[8]) ? trim($columns[8]) : '';
  if (!in_array($type, $allowedTyp)) {
      continue; // Skip rows with invalid mark
  }

    // Validate mark
$nature = isset($columns[10]) ? trim($columns[10]) : '';
if (!in_array($nature, $allowedNatures)) {
    continue; // Skip rows with invalid mark
}


                $manf_date = isset($columns[4]) ? trim($columns[4]) : '';
                if ($manf_date) {
                    $dateObj = DateTime::createFromFormat('d/m/Y', $manf_date);
                    if ($dateObj) {
                        $manf_date = $dateObj->format('Y-m-d');
                    }
                }

                $dataToInsert[] = [
                    'auction_no' => $auction_no,
                    'warehouse' => trim($columns[1] ?? ''),
                    'mark' => $mark,
                    'grade' => trim($columns[3] ?? ''),
                    'manf_date' => $manf_date,
                    'certification' => trim($columns[5] ?? ''),
                    'invoice' => trim($columns[6] ?? ''),
                    'no_of_pkgs' => trim($columns[7] ?? ''),
                    'type' => trim($columns[8] ?? ''),
                    'net_weight' => trim($columns[9] ?? ''),
                    'nature' => trim($columns[10] ?? '')
                ];
            }
        }
    
        // Store the extracted data in session for editing
        $_SESSION['dataToInsert'] = $dataToInsert;
    
    } catch (Exception $e) {
        echo "<script>alert('Error processing file: " . $e->getMessage() . "');</script>";
        exit;
    }
}


// Handle form submission to insert or update data
if (isset($_POST['submit_edit'])) {
    if (isset($_SESSION['dataToInsert']) && is_array($_SESSION['dataToInsert'])) {
        $successMessages = [];
        $errorMessages = [];
        $emptyRowFound = false; // Flag to check if any empty field exists

        foreach ($_SESSION['dataToInsert'] as $index => $row) {
            $rowHasEmptyField = false; // Track if the row has any empty field

            // Validate if any field is empty
            foreach ($row as $key => $value) {
                if (empty($value)) {
                    $rowHasEmptyField = true; // Flag this row as having an empty field
                    $errorMessages[] = "Field '$key' is empty for Auction No: " . $row['auction_no'];
                    break; // Exit the loop for this row if any field is empty
                }
            }

            // Skip the current row if it has any empty field
            if ($rowHasEmptyField) {
                $emptyRowFound = true;
                continue; // Skip processing this row
            }
            $auction_no = $row['auction_no'];
            $invoice = $row['invoice'];

            // Check for duplicate invoice
            $duplicateCheckQuery = "SELECT COUNT(*) AS count FROM user_inputs WHERE auction_no = ? AND invoice = ?";
            $stmt = $conn->prepare($duplicateCheckQuery);
            $stmt->bind_param("ss", $auction_no, $invoice);
            $stmt->execute();
            $result = $stmt->get_result();
            $count = $result->fetch_assoc()['count'];

            if ($count > 0) {
                // Add an error message if duplicate is found
                $errorMessages[] = "Invoice $invoice already exists for auction No $auction_no";
                continue; // Skip this row and proceed to the next
            }

        // Insert data into the database
        $auction_no = mysqli_real_escape_string($conn, $row['auction_no']);
        $warehouse = mysqli_real_escape_string($conn, $row['warehouse']);
        $mark = mysqli_real_escape_string($conn, $row['mark']);
        $grade = mysqli_real_escape_string($conn, $row['grade']);
        $manf_date = mysqli_real_escape_string($conn, $row['manf_date']);
        $certification = mysqli_real_escape_string($conn, $row['certification']);
        $no_of_pkgs = mysqli_real_escape_string($conn, $row['no_of_pkgs']);
        $type = mysqli_real_escape_string($conn, $row['type']);
        $net_weight = mysqli_real_escape_string($conn, $row['net_weight']);
        $nature = mysqli_real_escape_string($conn, $row['nature']);

         // Insert data into the database
         $insertQuery = "INSERT INTO user_inputs (auction_no, warehouse, mark, grade, manf_date, certification, invoice, no_of_pkgs, type, net_weight, nature) 
         VALUES ('" . $row['auction_no'] . "', '" . $row['warehouse'] . "', '" . $row['mark'] . "', '" . $row['grade'] . "', '" . $row['manf_date'] . "', '" . $row['certification'] . "', '" . $row['invoice'] . "', '" . $row['no_of_pkgs'] . "', '" . $row['type'] . "', '" . $row['net_weight'] . "', '" . $row['nature'] . "')";
if (mysqli_query($conn, $insertQuery)) {
$successMessages[] = "Successfully inserted data for Auction No: " . $row['auction_no'];
} else {
$errorMessages[] = "Error inserting data for Auction No: " . $row['auction_no'] . " - " . mysqli_error($conn);
}
}

        // Show the errors or success messages
        if (!empty($errorMessages)) {
            echo "<script>alert('" . implode('\n', $errorMessages) . "');</script>";
        } else {
            echo "<script>alert('" . implode('\n', $successMessages) . "');</script>";
        }

        // If any row had empty fields, reload the page to reflect the error
        if ($emptyRowFound) {
            echo "<script>alert('One or more fields are empty. Please fill all the required fields.');</script>";
            echo "<script>window.location.href = window.location.href;</script>"; // Reload the page
        } else {
            echo "<script>window.location.href = window.location.href;</script>"; // Reload page to display the uploaded table
        }
    } else {
        echo "<script>alert('No data available to insert. Please upload a file first.');</script>";
    }
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

