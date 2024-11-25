<?php
header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "vtbl_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

// Handle GET request to fetch the starting lot for a specific auction_no
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['auction_no'])) {
    $auction_no = $_GET['auction_no'];

    // Check if auction_no is dashed or non-dashed
    if (strpos($auction_no, '-') !== false) {
        // Dashed auction_no (treated as string)
        $stmt = $conn->prepare("SELECT starting_lot FROM auction_dates WHERE auction_no = ?");
        $stmt->bind_param("s", $auction_no); // Bind as string
    } else {
        // Non-dashed auction_no (treated as integer)
        $stmt = $conn->prepare("SELECT starting_lot FROM auction_dates WHERE auction_no = ?");
        $stmt->bind_param("i", $auction_no); // Bind as integer
    }

    $stmt->execute();
    $stmt->bind_result($starting_lot);
    $stmt->fetch();
    $stmt->close();

    // Return a response with the starting lot or a default value if not found
    echo json_encode(['starting_lot' => $starting_lot ?? null]);
    exit;
}

// Handle POST request to insert or update starting lot
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['auction_no']) && isset($data['starting_lot'])) {
        $auction_no = $data['auction_no'];
        $starting_lot = (int) $data['starting_lot'];

        // Check if auction_no is dashed or non-dashed
        if (strpos($auction_no, '-') !== false) {
            // Dashed auction_no (treated as string)
            $stmt = $conn->prepare("INSERT INTO auction_dates (auction_no, starting_lot) VALUES (?, ?) ON DUPLICATE KEY UPDATE starting_lot = ?");
            $stmt->bind_param("sii", $auction_no, $starting_lot, $starting_lot);
        } else {
            // Non-dashed auction_no (treated as integer)
            $stmt = $conn->prepare("INSERT INTO auction_dates (auction_no, starting_lot) VALUES (?, ?) ON DUPLICATE KEY UPDATE starting_lot = ?");
            $stmt->bind_param("iii", $auction_no, $starting_lot, $starting_lot);
        }

        if ($stmt->execute()) {
            $message = $stmt->affected_rows > 1 ? "Starting lot updated successfully." : "New starting lot added successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
        echo json_encode(['message' => $message]);
        exit;
    } else {
        echo json_encode(['message' => "Invalid data. Both 'auction_no' and 'starting_lot' are required."]);
        exit;
    }
}

// Close database connection
$conn->close();
?>
