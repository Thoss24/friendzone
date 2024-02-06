<?php

$db_host = "localhost";
$db_user = "root";
$bd_password = "";
$db_name = "social_media_clone";

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $bd_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $error) {
    die("Error: " .$error->getMessage());
}

?>