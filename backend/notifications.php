<?php

require 'db_connect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $stmt = $conn->prepare('SELECT * FROM expired_friend_requests WHERE sender_id = ? AND seen = 0');
    $stmt->bind_param("s", $_SESSION['user_id']);
    $stmt->execute();

    $result = $stmt->get_result();
    $result_data = $result->fetch_all();

    echo json_encode($result_data);
}
if ($_SERVER['REQUEST_METHOD'] == 'PATCH'){

    $user_id = $_GET['id'];
    $seen = 1;

    $stmt = $conn->prepare('UPDATE expired_friend_requests SET seen = ? WHERE id = ?');
    $stmt->bind_param("ss", $seen, $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    echo json_encode($result->num_rows);
}

?>