<?php
$servername = "localhost";
$username = "root";
$password = ""; // No password
$dbname = "vtbl_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch auction number from the request
$auction_no = $_GET['auction_no'] ?? null;

$sql = "SELECT 
            IFNULL(CAST(comments AS CHAR), '') AS comments, 
            IFNULL(CAST(warehouse AS CHAR), '') AS warehouse, 
            IFNULL(CAST(value AS CHAR), '') AS value, 
            IFNULL(CAST(mark AS CHAR), '') AS mark, 
            IFNULL(CAST(grade AS CHAR), '') AS grade, 
            IFNULL(DATE_FORMAT(manf_date, '%d-%m-%Y'), '') AS manf_date, 
            IFNULL(CAST(certification AS CHAR), '') AS certification, 
            IFNULL(CAST(invoice AS CHAR), '') AS invoice, 
            IFNULL(CAST(no_of_pkgs AS CHAR), '') AS no_of_pkgs, 
            IFNULL(CAST(type AS CHAR), '') AS type, 
            IFNULL(CAST(net_weight AS CHAR), '') AS net_weight, 
            IFNULL(CAST(kg AS CHAR), '') AS kg,  -- Ensure 'kg' is fetched
            IFNULL(CAST(nature AS CHAR), '') AS nature, 
            IFNULL(CAST(sale_price AS CHAR), '') AS sale_price, 
            IFNULL(CAST(id AS CHAR), '') AS id
        FROM user_inputs";

if ($auction_no) {
    if (strpos($auction_no, '-') !== false) {
        // For dashed auction_no
        $sql .= " WHERE auction_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $auction_no); // Use "s" since dashed auction_no can be a string
    } else {
        // For non-dashed auction_no
        $sql .= " WHERE auction_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $auction_no); // Use "i" since non-dashed auction_no is likely an integer
    }
} else {
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Check if there is no data and return a blank structure
if (empty($data)) {
    $data[] = [
        "comments" => "",
        "warehouse" => "",
        "value" => "",
        "mark" => "",
        "grade" => "",
        "manf_date" => "",
        "certification" => "",
        "invoice" => "",
        "no_of_pkgs" => "",
        "type" => "",
        "net_weight" => "",
        "kg" => "",  // Include 'kg' in the blank structure
        "nature" => "",
        "sale_price" => "",
        "buyer_packages" => ""
    ];
}

$stmt->close();
$conn->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
