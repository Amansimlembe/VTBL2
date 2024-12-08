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

// Get the request type (fetch or save)
$request_type = $_POST['request_type'] ?? $_GET['request_type'];

if ($request_type === 'fetch') {
    // Fetch auction data
    $auction_no = $_GET['auction_no'] ?? '';

    if ($auction_no) {
        $sql = "SELECT * FROM auction_dates WHERE auction_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $auction_no); // Bind auction_no as a string
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            echo json_encode(["status" => "success", "data" => $data]);
        } else {
            echo json_encode(["status" => "error", "message" => "No data found."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Auction number is required."]);
    }
} elseif ($request_type === 'save') {
    // Save auction data
    $auction_no = $_POST['auction_no'] ?? '';
    $bank_name = $_POST['bank_name'] ?? '';
  
    if ($auction_no && $bank_name !== null) {
        $sql = "INSERT INTO auction_dates (auction_no, bank_name) 
                VALUES (?, ?)
                ON DUPLICATE KEY UPDATE bank_name = VALUES(bank_name)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $auction_no, $bank_name); // String, String, Decimal
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Auction details saved successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request type."]);
}

$conn->close();
?>
