<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vtbl_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve POST data
$id = $_POST['id'];  // The ID of the row you're replacing
$auction_no = $_POST['auction_no'];
$comments = $_POST['comments'];
$warehouse = $_POST['warehouse'];
$value = $_POST['value'];
$mark = $_POST['mark'];
$grade = $_POST['grade'];
$manf_date = $_POST['manf_date'];
$certification = $_POST['certification'];
$invoice = $_POST['invoice'];
$no_of_pkgs = $_POST['no_of_pkgs'];
$type = $_POST['type'];
$net_weight = $_POST['net_weight'];
$nature = $_POST['nature'];
$sale_price = $_POST['sale_price'];
$buyer_packages = $_POST['buyer_packages'];

// Delete the existing row with the specified `id`
$sql_delete = "DELETE FROM user_inputs WHERE id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $id);
$stmt_delete->execute();
$stmt_delete->close();

// Insert the new data as a new row
$sql_insert = "INSERT INTO user_inputs (auction_no, comments, warehouse, value, mark, grade, manf_date, certification, invoice, no_of_pkgs, type, net_weight, nature, sale_price, buyer_packages) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("issdssssssdsdss", $auction_no, $comments, $warehouse, $value, $mark, $grade, $manf_date, $certification, $invoice, $no_of_pkgs, $type, $net_weight, $nature, $sale_price, $buyer_packages);
$stmt_insert->execute();

if ($stmt_insert->affected_rows > 0) {
    echo "success";
} else {
    echo "Failed to replace data.";
}

// Close connections
$stmt_insert->close();
$conn->close();
?>
