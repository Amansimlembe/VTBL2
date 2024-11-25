<?php

$server_name = "localhost";
$user_name = "root";
$password = "";
$db_name = "vtbl_login";


$conn = mysqli_connect( $server_name, $user_name, $password,$db_name);

if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>
