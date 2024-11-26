<?php
require 'db_connection.php'; // Include your database connection file

if (isset($_POST['submit_edit']) && !empty($_POST['data'])) {
    $data = $_POST['data'];
    $successMessages = [];
    $errorMessages = [];
    $emptyRowFound = false;

    foreach ($data as $row) {
        foreach ($row as $key => $value) {
            if (empty($value)) {
                $emptyRowFound = true;
                $errorMessages[] = "Field '$key' is empty for Auction No: " . $row['auction_no'];
                break;
            }
        }

        if ($emptyRowFound) {
            continue; // Skip this row if any field is empty
        }

        // Prepare variables from row data
        $auction_no = $row['auction_no'];
        $warehouse = $row['warehouse'];
        $mark = $row['mark'];
        $grade = $row['grade'];
        $manf_date = $row['manf_date'];
        $certification = $row['certification'];
        $invoice = $row['invoice'];
        $no_of_pkgs = $row['no_of_pkgs'];
        $type = $row['type'];
        $net_weight = $row['net_weight'];
        $nature = $row['nature'];
        $sale_price = isset($row['sale_price']) ? $row['sale_price'] : null;  // Optional field
        $buyer_packages = isset($row['buyer_packages']) ? $row['buyer_packages'] : null;  // Optional field

        // Check if the combination of auction_no and invoice already exists
        $checkQuery = "SELECT COUNT(*) FROM user_inputs WHERE auction_no = '$auction_no' AND invoice = '$invoice'";
        $checkResult = mysqli_query($conn, $checkQuery);
        $checkRow = mysqli_fetch_row($checkResult);

        if ($checkRow[0] > 0) {
            $errorMessages[] = " Invoice: $invoice already exist for auction No: $auction_no. ";
            continue; // Skip this row if a duplicate invoice is found for the same auction_no
        }

        // Prepare SQL Insert query (ignores duplicate invoices for the same auction_no)
        $query = "INSERT INTO user_inputs (
            auction_no, warehouse, mark, grade, manf_date, certification, 
            invoice, no_of_pkgs, type, net_weight, nature, sale_price, buyer_packages
        ) VALUES (
            '$auction_no', '$warehouse', '$mark', '$grade', '$manf_date', '$certification', 
            '$invoice', '$no_of_pkgs', '$type', '$net_weight', '$nature', '$sale_price', '$buyer_packages'
        )";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $successMessages[] = "Inserted data for Auction No: $auction_no with Invoice: $invoice";
        } else {
            $errorMessages[] = "Failed to insert data for Auction No: $auction_no with Invoice: $invoice";
        }
    }

    // Return response with success and error messages
    echo json_encode([
        'success' => $successMessages,
        'errors' => $errorMessages,
        'emptyRowFound' => $emptyRowFound
    ]);
} else {
    echo json_encode(['errors' => ['No data received for processing.']]);
}
?>
