<?php
$connection = new mysqli('localhost', 'root', '', 'vtbl_db');

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['auction_no'])) {
    $auction_no = $_POST['auction_no'];

    // Prepare the SQL query to fetch data ordered by lot_number numerically
    $stmt = $connection->prepare("
        SELECT date_sold, lot_number, sell_mark, invoice, packages, net_weight, grade, price, proceeds, buyer_name, warehouse, status 
        FROM sales_result 
        WHERE auction_no = ? 
        ORDER BY CAST(lot_number AS UNSIGNED) ASC
    ");
    $stmt->bind_param("s", $auction_no);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize summary variables
    $kilosOffered = 0;
    $kilosSold = 0;
    $pkgsOffered = 0;
    $pkgsSold = 0;
    $totalProceeds = 0;

    // Generate HTML table rows and calculate the summary
    $output = '';
    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>';
        foreach ($row as $value) {
            $output .= '<td>' . htmlspecialchars($value) . '</td>';
        }
        $output .= '</tr>';

        // Calculate kilos and packages offered/sold, and total proceeds
        $kilosOffered += $row['net_weight'];
        $pkgsOffered += $row['packages'];

        // If the item is sold, calculate kilos sold, packages sold, and total proceeds
        if ($row['status'] == 'Sold') {
            $kilosSold += $row['net_weight'];
            $pkgsSold += $row['packages'];
            $totalProceeds += ($row['price'] * $row['net_weight']) / 100; // Assuming price is per kg
        }
    }

    // Calculate summary values
    $percentSold = $kilosOffered > 0 ? ($kilosSold / $kilosOffered) * 100 : 0;
    $avgPrice = $kilosSold > 0 ? $totalProceeds*100 / $kilosSold : 0;

    // Prepare the response as an array
    $response = [
        'tableRows' => $output,
        'kilosOffered' => $kilosOffered,
        'kilosSold' => $kilosSold,
        'pkgsOffered' => $pkgsOffered,
        'pkgsSold' => $pkgsSold,
        'totalProceeds' => number_format($totalProceeds),
        'percentSold' => number_format($percentSold) . "%",
        'avgPrice' => number_format($avgPrice )
    ];

    // Return the response as JSON
    echo json_encode($response);

    $stmt->close();
}
?>
