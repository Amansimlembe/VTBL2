<?php
$connection = new mysqli('localhost', 'root', '', 'vtbl_db');

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['auction_no'], $_POST['marks'])) {
    $auction_no = $_POST['auction_no'];
    $marks = json_decode($_POST['marks'], true); // Decode JSON string into PHP array

    // Validate marks input
    if (!is_array($marks) || empty($marks)) {
        echo json_encode(['error' => 'Invalid marks data']);
        exit;
    }

    // Create placeholders for the IN clause
    $placeholders = implode(',', array_fill(0, count($marks), '?'));
    $sql = "
        SELECT date_sold, lot_number, sell_mark, invoice, packages, net_weight, grade, price, proceeds, buyer_name, warehouse, status 
        FROM sales_result 
        WHERE auction_no = ? AND sell_mark IN ($placeholders)
        ORDER BY CAST(lot_number AS UNSIGNED) ASC
    ";

    // Prepare the statement
    $stmt = $connection->prepare($sql);
    $bindParams = array_merge([$auction_no], $marks);
    $stmt->bind_param(str_repeat('s', count($bindParams)), ...$bindParams);
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
        $kilosOffered += (float)$row['net_weight'];
        $pkgsOffered += (int)$row['packages'];

        // If the item is sold, calculate kilos sold, packages sold, and total proceeds
        if ($row['status'] == 'Sold') {
            $kilosSold += (float)$row['net_weight'];
            $pkgsSold += (int)$row['packages'];
            $totalProceeds += ((float)$row['price'] / 100) * (float)$row['net_weight']; // Assuming price is per kg
        }
    }

    // Calculate summary values
    $percentSold = $kilosOffered > 0 ? ($kilosSold / $kilosOffered) * 100 : 0;
    $avgPrice = $kilosSold > 0 ? $totalProceeds*100 / $kilosSold : 0;

    // Prepare the response as an array
    $response = [
        'tableRows' => $output,
        'kilosOffered' => number_format($kilosOffered),
        'kilosSold' => number_format($kilosSold),
        'pkgsOffered' => $pkgsOffered,
        'pkgsSold' => $pkgsSold,
        'totalProceeds' => number_format($totalProceeds),
        'percentSold' => number_format($percentSold) . "%",
        'avgPrice' => number_format($avgPrice)
    ];

    // Return the response as JSON
    echo json_encode($response);

    $stmt->close();
}
?>
