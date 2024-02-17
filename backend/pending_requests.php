<?php

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    session_start();

    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare('SELECT friend_requests.friend_request_id, friend_requests.sender_id, person.name FROM friend_requests JOIN person WHERE recipient_id = ? AND friend_requests.sender_id = person.user_id');
    $stmt->bind_param("s", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $result_data = $result->fetch_all();

    echo json_encode($result_data);
}

?>