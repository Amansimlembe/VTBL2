<?php
session_start();
require 'vendor/autoload.php'; // Composer Autoload

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
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed']));
}

// Allowed lists
$allowedMarks = ['Chivanjee', 'kibena', 'Itona', 'Ikanga', 'Kiganga', 'Kibwele', 'Lugoda', 'Kilima', 'kabambe', 'Luponde', 'Lupembe', 'Katumba', 'Mwakaleli', 'Livingstonia', 'Arc mountain', 'Dindira', 'Kwamkoro', 'Mponde', 'Kagera'];
$allowedGrades = ['BP1', 'PF1', 'PD', 'D1', 'BP', 'PF', 'D2', 'DUST', 'FNGS', 'BMF', 'Orthodox'];
$allowedNatures = ['Fresh', 'Reprint'];
$allowedWarehouses = ['Bravo', 'EUTEACO'];
$allowedTyp = ['TPP', 'PB'];
$allowedCertifications = ['Non RA', 'RA'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['uploaded_file'])) {
    $file = $_FILES['uploaded_file'];
    $fileTmpPath = $file['tmp_name'];
    $fileName = $file['name'];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = ['xlsx', 'xls', 'csv', 'pdf', 'docx'];

    if (!in_array($fileType, $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Please upload an Excel, PDF, or Word file.']);
        exit;
    }

    try {
        $dataToInsert = [];

        if ($fileType === 'xlsx' || $fileType === 'xls' || $fileType === 'csv') {
            $spreadsheet = IOFactory::load($fileTmpPath);
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            foreach ($sheetData as $row) {
                // Apply validation and process data as in your original code
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
    
         // Add logic for PDF and DOCX if necessary

        $_SESSION['dataToInsert'] = $dataToInsert;
        echo json_encode(['status' => 'success', 'message' => 'File processed successfully!', 'data' => $dataToInsert]);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error processing file: ' . $e->getMessage()]);
    }
}
?>
