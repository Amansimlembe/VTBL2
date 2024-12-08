<?php
$connection = new mysqli('localhost', 'root', '', 'vtbl_db');
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the auction number from the GET request
$auction_no = isset($_GET['auction_no']) ? $_GET['auction_no'] : '';

// Fetch sales result data for the selected auction number where status is 'Sold'
if ($auction_no) {
    $query = "SELECT * FROM sales_result WHERE auction_no = ? AND status = 'Sold' ORDER BY CAST(lot_number AS UNSIGNED) ASC";

    if ($stmt = $connection->prepare($query)) {
        $stmt->bind_param("i", $auction_no); // Bind the auction number
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch and output the data
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['date_sold']) . "</td>";
                echo "<td>" . htmlspecialchars($row['lot_number']) . "</td>";
                echo "<td>" . htmlspecialchars($row['sell_mark']) . "</td>";
                echo "<td>" . htmlspecialchars($row['invoice']) . "</td>";
                echo "<td>" . htmlspecialchars($row['packages']) . "</td>";
                echo "<td>" . htmlspecialchars($row['net_weight']) . "</td>";
                echo "<td>" . htmlspecialchars($row['grade']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['proceeds']) . "</td>";
                echo "<td>" . htmlspecialchars($row['buyer_name']) . "</td>"; // Ensure buyer_name is included
                echo "<td>" . htmlspecialchars($row['warehouse']) . "</td>";
                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='12'>No sold results found for this auction number.</td></tr>";
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $connection->error;
    }
}

$connection->close();
?>
