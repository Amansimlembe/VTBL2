<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'vtbl_db';

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle AJAX request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auctionNo = $_POST['auction_no'];

    if (isset($_POST['exchange_rate'])) {
        // Save exchange rate
        $exchangeRate = $_POST['exchange_rate'];

        $stmt = $conn->prepare("UPDATE auction_dates SET exchange_rate = ? WHERE auction_no = ?");
        $stmt->bind_param('ds', $exchangeRate, $auctionNo);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Exchange rate saved successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save exchange rate.']);
        }
        $stmt->close();
    } else {
        // Fetch exchange rate
        $stmt = $conn->prepare("SELECT exchange_rate FROM auction_dates WHERE auction_no = ?");
        $stmt->bind_param('s', $auctionNo);
        $stmt->execute();
        $stmt->bind_result($exchangeRate);
        $stmt->fetch();

        if ($exchangeRate !== null) {
            echo json_encode(['status' => 'success', 'exchange_rate' => $exchangeRate]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Exchange rate not found.']);
        }
        $stmt->close();
    }
}

$conn->close();
?>
