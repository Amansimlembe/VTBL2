<?php
$connection = new mysqli('localhost', 'root', '', 'vtbl_db');

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['marks'])) {
    $marks = $_POST['marks'];

    if (!empty($marks)) {
        $marksPlaceholder = implode(',', array_fill(0, count($marks), '?'));
        $stmt = $connection->prepare("SELECT * FROM sales_results WHERE mark IN ($marksPlaceholder)");
        
        $stmt->bind_param(str_repeat('s', count($marks)), ...$marks);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['date_sold']}</td>
                    <td>{$row['lot_number']}</td>
                    <td>{$row['mark']}</td>
                    <td>{$row['invoice']}</td>
                    <td>{$row['packages']}</td>
                    <td>{$row['net_weight']}</td>
                    <td>{$row['grade']}</td>
                    <td>{$row['price']}</td>
                    <td>{$row['buyer_name']}</td>
                    <td>{$row['warehouse']}</td>
                    <td>{$row['status']}</td>
                </tr>";
            }
        } else {
            echo "";
        }
        $stmt->close();
    } else {
        echo "";
    }
}
$connection->close();
?>
