<?php
// Include database connection
$connection = new mysqli('localhost', 'root', '', 'vtbl_db');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auction_no = $_POST['auction_no'];
    $invoice = $_POST['invoice'];

    // Query to check if the invoice already exists for the selected auction_no
    $query = $connection->prepare("SELECT COUNT(*) FROM sales_result WHERE auction_no = ? AND invoice = ?");
    $query->bind_param("is", $auction_no, $invoice);
    $query->execute();
    $query->bind_result($count);
    $query->fetch();

    // If count > 0, invoice already exists
    if ($count > 0) {
        echo 'exists';
    } else {
        echo 'unique';
    }
}
?>
