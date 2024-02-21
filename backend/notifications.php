<?php

require 'db_connect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $conn->prepare('SELECT * FROM expired_friend_requests WHERE sender_id = ?');
    $stmt->bind_param("s", $_SESSION['user_id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $result_data = $result->fetch_all();

    echo json_encode($result_data);
}

?>