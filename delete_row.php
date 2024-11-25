<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    
    $stmt = $conn->prepare("DELETE FROM user_inputs WHERE id = ?");
    $stmt->bind_param("i", $id);

    echo ($stmt->execute()) ? "success" : "error";

    $stmt->close();
    $conn->close();
}
?>
