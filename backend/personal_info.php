<?php

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $user_id = $_GET['id'];

    $stmt = $conn->prepare('SELECT * FROM person WHERE user_id = ?');
    $stmt->bind_param("s", $user_id);
    $stmt->execute();

    $user = $stmt->get_result();
    $user_data = $user->fetch_all();

    echo json_encode($user_data);
}

?>