<?php
$connection = new mysqli('localhost', 'root', '', 'vtbl_db');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['auction_no'])) {
    $auction_no = $_POST['auction_no'];

    $stmt = $connection->prepare("SELECT date_sold, lot_number, sell_mark, invoice, packages, net_weight, grade, price, buyer_name, warehouse, status FROM sales_result WHERE auction_no = ?");
    $stmt->bind_param("s", $auction_no);
    $stmt->execute();
    $result = $stmt->get_result();

    $output = '';
    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>';
        foreach ($row as $value) {
            $output .= '<td>' . htmlspecialchars($value) . '</td>';
        }
        $output .= '</tr>';
    }

    echo $output;
    $stmt->close();
}
?>
