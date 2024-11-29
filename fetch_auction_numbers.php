<?php
// Database connection
$connection = new mysqli('localhost', 'root', '', 'vtbl_db');

// Check for any connection errors
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the year from the request
$year = $_GET['year'];

if ($year != "") {
    // Query to fetch auction numbers for the selected year
    $query = "SELECT auction_no FROM auction_dates WHERE YEAR(auction_date) = ? ORDER BY auction_date ASC";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $year); // Bind the year parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the query returned any results
    if ($result->num_rows > 0) {
        // Loop through the result and populate the dropdown options
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['auction_no'] . "'>" . $row['auction_no'] . "</option>";
        }
    } else {
        echo "<option value=''>No auctions available for this year</option>";
    }

    // Close the statement and connection
    $stmt->close();
} else {
    echo "<option value=''>Select Year first</option>";
}

$connection->close();
?>
