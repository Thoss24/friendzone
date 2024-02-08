<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PATCH, POST, GET, OPTIONS, DELETE');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

$db_host = "localhost";
$db_user = "root";
$bd_password = "";
$db_name = "social_media_clone";

// try {
//     $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $bd_password);
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// } catch (PDOException $error) {
//     die("Error: " .$error->getMessage());
// }

$conn = new mysqli($db_host, $db_user, $bd_password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>