<?php
// Database configuration
$host = 'localhost'; 
$username = 'root'; 
$password = ''; 
$database = 'vtbl_db'; 

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if an auction number is provided
if (isset($_GET['auction_no'])) {
    $auction_no = $_GET['auction_no']; // Auction number can be dashed or non-dashed
    $sql = "";

    // Determine whether auction_no is dashed or not
    if (strpos($auction_no, '-') !== false) {
        // Handle dashed auction_no as a string
        $sql = "SELECT closing_date, auction_date, prompt_date FROM auction_dates WHERE auction_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $auction_no); // String parameter
    } else {
        // Handle non-dashed auction_no as an integer
        $auction_no = intval($auction_no);
        $sql = "SELECT closing_date, auction_date, prompt_date FROM auction_dates WHERE auction_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $auction_no); // Integer parameter
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        // Format the dates to DD-MM-YYYY
        $data['closing_date'] = date("d-m-Y", strtotime($data['closing_date']));
        $data['auction_date'] = date("d-m-Y", strtotime($data['auction_date']));
        $data['prompt_date'] = date("d-m-Y", strtotime($data['prompt_date']));
        
        // Return the data as JSON
        echo json_encode($data);
    } else {
        echo json_encode(null); // No data found for the provided auction_no
    }

    
    $stmt->close();
} else {
    echo json_encode(['error' => 'No auction number provided']);
}

$conn->close();
?>
