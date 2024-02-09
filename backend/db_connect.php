<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PATCH, POST, GET, OPTIONS, DELETE');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

$db_host = "localhost";
$db_user = "root";
$bd_password = "";
$db_name = "social_media_clone";

$conn = new mysqli($db_host, $db_user, $bd_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>