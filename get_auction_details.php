<?php
$conn = new mysqli("localhost", "root", "", "vtbl_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['auction_no'])) {
    $auction_no = $_GET['auction_no'];
    $stmt = $conn->prepare("SELECT main_lot, secondary_lot, start_lot FROM row_limit WHERE auction_no = ?");
    $stmt->bind_param("i", $auction_no);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
    $stmt->close();
}

$conn->close();
?>
