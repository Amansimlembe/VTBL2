<?php
// Include your database connection file
require_once 'db_connection.php'; // Update this with your database connection file name

// Check if the necessary data is provided in the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['lot_no'])) {
    $id = intval($_POST['id']); // Get the ID of the row
    $lot_no = intval($_POST['lot_no']); // Get the updated Lot No

    // Validate inputs
    if ($id > 0 && $lot_no > 0) {
        // Prepare the SQL query to update the Lot No
        $query = "UPDATE user_inputs SET lot_no = ? WHERE id = ?";
        
        // Use a prepared statement to prevent SQL injection
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('ii', $lot_no, $id);

            // Execute the query
            if ($stmt->execute()) {
                echo "Lot No updated successfully.";
            } else {
                echo "Error updating Lot No: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error preparing the statement: " . $conn->error;
        }
    } else {
        echo "Invalid ID or Lot No.";
    }
} else {
    echo "Invalid request. Please provide both ID and Lot No.";
}

// Close the database connection
$conn->close();
?>
