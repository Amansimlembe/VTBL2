<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$connection = new mysqli('localhost', 'root', '', 'vtbl_db');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auction_no = $_POST['auction_no3'];
    $file = $_FILES['file']['tmp_name'];

    if (!empty($auction_no) && !empty($file)) {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Arrays to store alerts
        $success_alerts = [];
        $error_alerts = [];

        // Predefined lists
        $valid_grades = ['BP1', 'PF1', 'PD', 'D1', 'BP', 'PF', 'FNGS', 'D2', 'DUST', 'BMF', 'Orthodox'];
        $grade_exceptions = [
            'dust1' => 'D1',
            'dust2' => 'D2',
            'DUST2' => 'D2',
            'Dust2' => 'D2',
            'Dust1' => 'D1',
            'DUST1' => 'D1'
        ];

        foreach ($rows as $index => $row) {
            if ($index === 0) {
                // Skip header row
                continue;
            }

            // Map row data to variables
            $date_sold_raw = $row[0];
            $lot_number = $row[1];
            $sell_mark = $row[2];
            $invoice = $row[3];
            $packages = (int)$row[4];
            $net_weight = str_replace(',', '', $row[5]);
            $grade = trim($row[6]);
            $price_raw = str_replace(',', '', $row[7]);
            $price = (empty($price_raw) || $price_raw === '-') ? 0 : $price_raw;
            $buyer_name = $row[8];
            $warehouse = $row[9];
            $status = $row[10];

            // Validate and normalize grade
            $grade = preg_replace('/\s*(?<=\D)(?=\d)/', '', $grade); // Remove spaces between letters and numbers
            $normalized_grade = array_key_exists(strtolower($grade), $grade_exceptions) 
                ? $grade_exceptions[strtolower($grade)] 
                : ucwords(strtolower($grade));
            
            $grade_matched = array_filter($valid_grades, function ($gr) use ($normalized_grade) {
                return strtolower($gr) === strtolower($normalized_grade);
            });

            if (empty($grade_matched)) {
                $error_alerts[] = "Invalid grade \"$grade\" in $index.";
                continue;
            }
            $grade = reset($grade_matched);

            // Normalize sell mark
            $valid_marks = ['Chivanjee', 'Kibena', 'Itona', 'Ikanga', 'Kiganga', 'Kibwere', 'Lugoda', 'Kilima', 
                'Kabambe', 'Luponde', 'Lupembe', 'Katumba', 'Mwakaleli', 'Livingstonia', 'Arc Mountain', 
                'Dindira', 'Kwamkoro', 'Mponde', 'Kagera'];
            $sell_mark = ucwords(strtolower(trim($sell_mark)));
            if (!in_array($sell_mark, $valid_marks)) {
                $error_alerts[] = "Invalid mark \"$sell_mark\" in $index. ";
                continue;
            }

            // Normalize warehouse
            $valid_warehouses = ['Bravo', 'Euteaco'];
            $warehouse = ucwords(strtolower(trim($warehouse)));
            if (!in_array($warehouse, $valid_warehouses)) {
                $error_alerts[] = "Invalid warehouse \"$warehouse\" in $index.";
                continue;
            }

            // Validate date format (assume input format is dd/mm/yyyy)
            $date_sold = date('Y-m-d', strtotime(str_replace('/', '-', $date_sold_raw)));

            // Validate Lot Number
            if (!is_numeric($lot_number) || intval($lot_number) != $lot_number) {
                $error_alerts[] = "Invalid Lot \"$lot_number\" in  $index.";
                continue;
            }

            // Skip rows with missing critical fields
            if (empty($date_sold) || empty($lot_number) || empty($sell_mark) || empty($invoice)) {
                $error_alerts[] = "Missing critical data in $index.";
                continue;
            }

            // Check if the combination of auction_no and invoice already exists
            $query = $connection->prepare(
                "SELECT date_sold, sell_mark, packages, net_weight, grade, price, buyer_name, warehouse, status 
                FROM sales_result 
                WHERE auction_no = ? AND invoice = ? AND lot_number = ?"
            );
            $query->bind_param("ssi", $auction_no, $invoice, $lot_number);
            $query->execute();
            $query->store_result();

            if ($query->num_rows > 0) {
                // Check if the data is identical
                $query->bind_result($db_date_sold, $db_sell_mark, $db_packages, $db_net_weight, $db_grade, $db_price, $db_buyer_name, $db_warehouse, $db_status);
                $query->fetch();

                if (
                    $db_date_sold === $date_sold && 
                    $db_sell_mark === $sell_mark && 
                    (int)$db_packages === $packages && 
                    (float)$db_net_weight == (float)$net_weight && 
                    $db_grade === $grade && 
                    (float)$db_price == (float)$price && 
                    $db_buyer_name === $buyer_name && 
                    $db_warehouse === $warehouse && 
                    $db_status === $status
                ) {
                    $error_alerts[] = "Row for Lot \"$lot_number\" and Invoice \"$invoice\" in Auction \"$auction_no\" is identical. Skipping.";
                    continue;
                }

                // Update the row
                $update_query = $connection->prepare(
                    "UPDATE sales_result 
                    SET date_sold = ?, sell_mark = ?, packages = ?, net_weight = ?, grade = ?, price = ?, buyer_name = ?, warehouse = ?, status = ? 
                    WHERE auction_no = ? AND invoice = ? AND lot_number = ?"
                );
                $update_query->bind_param(
                    "ssidsdsssisi",
                    $date_sold, $sell_mark, $packages, $net_weight, $grade, $price, $buyer_name, $warehouse, $status,
                    $auction_no, $invoice, $lot_number
                );
                if ($update_query->execute()) {
                    $success_alerts[] = "Row for Lot \"$lot_number\" and Invoice \"$invoice\" in Auction \"$auction_no\" has been updated.";
                } else {
                    $error_alerts[] = "Failed to update row for Lot \"$lot_number\" and Invoice \"$invoice\": " . $update_query->error;
                }
                $update_query->close();
            } else {
                // Insert the row
                $stmt = $connection->prepare(
                    "INSERT INTO sales_result 
                    (auction_no, date_sold, lot_number, sell_mark, invoice, packages, net_weight, grade, price, buyer_name, warehouse, status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
                );
                $stmt->bind_param(
                    "sssssiisssss",
                    $auction_no, $date_sold, $lot_number, $sell_mark, $invoice, $packages, $net_weight, $grade, $price, $buyer_name, $warehouse, $status
                );

                if ($stmt->execute()) {
                    $success_alerts[] = "Row for Lot \"$lot_number\" and Invoice \"$invoice\" has been inserted.";
                } else {
                    $error_alerts[] = "Error inserting row for Lot \"$lot_number\" and Invoice \"$invoice\": " . $stmt->error;
                }

                $stmt->close();
            }

            $query->close();
        }

        // Display alerts
        if (!empty($success_alerts)) {
            echo implode('<br>', $success_alerts);
        }
        if (!empty($error_alerts)) {
            echo implode('<br>', $error_alerts);
        }
    } else {
        echo "alert('Auction number or file is missing.');";
    }
}
?>
