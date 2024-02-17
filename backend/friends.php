<?php

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    session_start();

    $current_user_name = $_SESSION['email'];

    $stmt = $conn->prepare("SELECT user_id, name FROM person WHERE email <> ?");
    $stmt->bind_param("s", $current_user_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $result_data = $result->fetch_all();

    echo json_encode($result_data);
}
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $sender_id = $_POST['sender_id'];
    $recipient_id = $_POST['recipient_id'];

    $stmt = $conn->prepare("SELECT * FROM friend_requests WHERE sender_id = ? AND recipient_id = ?");
    $stmt->bind_param("ss", $sender_id, $recipient_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $result_data = $result->fetch_assoc();

    if ($result->num_rows > 0 && $result_data['status'] == 'pending') {
        echo "You already have a friend request pending with this person";
    } 
    else if ($result->num_rows > 0 && $result_data['status'] == 'accepted') {
        echo "You are already friends with this person";
    }

    if ($result->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO friend_requests (sender_id, recipient_id) VALUES (?, ?)");
        $stmt->bind_param("ss", $sender_id, $recipient_id);
        $stmt->execute();

        echo "Friend request sent successfully";
    }

}

?>