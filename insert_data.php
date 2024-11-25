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

// Insert data into user_inputs table
$sql = "INSERT INTO user_inputs (auction_no, comments, warehouse, value, mark, grade, manf_date, certification, invoice, no_of_pkgs, type, net_weight, nature, sale_price, buyer_packages) 
        VALUES ('$auction_no', '$comments', '$warehouse', '$value', '$mark', '$grade', '$manf_date', '$certification', '$invoice', '$no_of_pkgs', '$type', '$net_weight', '$nature', '$sale_price', '$buyer_packages')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
