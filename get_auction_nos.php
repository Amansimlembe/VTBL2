<?php
if (isset($_GET['year'])) {
    $year = $_GET['year'];
    $conn = new mysqli("localhost", "root", "", "vtbl_db");

    // Query to get auction_no for the selected year
    $result = $conn->query("SELECT auction_no FROM auction_dates WHERE YEAR(auction_date) = $year ORDER BY auction_date");

    // Create an array to hold the auction numbers
    $auctionNos = [];
    while ($row = $result->fetch_assoc()) {
        $auctionNos[] = $row['auction_no'];
    }

    // Return the auction numbers as JSON
    echo json_encode($auctionNos);

    $conn->close();
}
?>
