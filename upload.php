<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$connection = new mysqli('localhost', 'root', '', 'vtbl_db');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auction_no = $_POST['auction_no'];
    $file = $_FILES['file']['tmp_name'];

    if (!empty($auction_no) && !empty($file)) {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        // Skip the header row and start from the first row of data
        foreach ($rows as $index => $row) {
            if ($index === 0) {
                // Optionally, check if headers match expected ones
                continue; // Skip header
            }

            // Map row data to variables
            $date_sold_raw = $row[0];
            $lot_number = $row[1];
            $sell_mark = $row[2];
            $invoice = $row[3];
            $packages = (int)$row[4];
            
            // Remove commas from Net Weight
            $net_weight = str_replace(',', '', $row[5]);
            $grade = $row[6];

            // Handle price: remove commas, check for empty or dash, replace with zero
            $price_raw = str_replace(',', '', $row[7]);
            $price = (empty($price_raw) || $price_raw === '-') ? 0 : $price_raw;

            $buyer_name = $row[8];
            $warehouse = $row[9];
            $status = $row[10];

            // Validate if the Lot Number is an integer
            if (!is_numeric($lot_number) || intval($lot_number) != $lot_number) {
                continue; // Skip this row if Lot Number is not a valid integer
            }

            // Convert and validate date format (assume input format is dd/mm/yyyy)
            $date_sold = date('Y-m-d', strtotime(str_replace('/', '-', $date_sold_raw)));

            // Skip rows with missing critical fields
            if (empty($date_sold) || empty($lot_number) || empty($sell_mark) || empty($invoice)) {
                continue;
            }

            // Check if the combination of auction_no and invoice already exists
            $query = $connection->prepare("SELECT COUNT(*) FROM sales_result WHERE auction_no = ? AND invoice = ?");
            $query->bind_param("ss", $auction_no, $invoice);
            $query->execute();
            $query->bind_result($count);
            $query->fetch();
            $query->close();

            // If the combination exists, skip inserting this row and alert with invoice and reason
            if ($count > 0) {
                echo "<script>alert('Invoice \"$invoice\" already exists for Auction No \"$auction_no\".');</script>";
                continue;
            }

            // Check if the Lot Number already exists for the auction number
            $lotQuery = $connection->prepare("SELECT COUNT(*) FROM sales_result WHERE auction_no = ? AND lot_number = ?");
            $lotQuery->bind_param("si", $auction_no, $lot_number);
            $lotQuery->execute();
            $lotQuery->bind_result($lotCount);
            $lotQuery->fetch();
            $lotQuery->close();

            // If the Lot Number exists, skip inserting this row and alert with invoice and reason
            if ($lotCount > 0) {
                echo "<script>alert('Lot Number \"$lot_number\" already exists for Auction No \"$auction_no\" (Invoice: \"$invoice\").');</script>";
                continue;
            }

            // Insert the row into the database
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
                echo "Invoice '$invoice' with Lot Number '$lot_number' has been inserted for Auction No '$auction_no'.";
            } else {
                echo "Error inserting row for Invoice '$invoice': " . $stmt->error . "";
            }

            $stmt->close();
        }
        
    } else {
        echo "Auction number or file is missing.";
    }
}
?>
