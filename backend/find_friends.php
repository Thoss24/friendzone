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

    $request_data = json_decode(file_get_contents("php://input"), true);

    $sender_id = $request_data['userId'];
    $recipient_id = $request_data['recipientId'];

    $stmt = $conn->prepare("SELECT * FROM friend_requests WHERE sender_id = ? AND recipient_id = ? OR recipient_id = ? AND sender_id = ?");
    $stmt->bind_param("ssss", $sender_id, $recipient_id, $sender_id, $recipient_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $result_data = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        echo "You already have a friend request pending with this person";
    } else if ($result->num_rows == 0) {

        $check_friendship_stmt = $conn->prepare(
        'SELECT * FROM friendship
        WHERE ? = person_id1 AND ? = person_id2 
        OR ? = person_id2 AND ? = person_id1');

        $check_friendship_stmt->bind_param("ssss", $recipient_id, $sender_id, $recipient_id, $sender_id);
        $check_friendship_stmt->execute();

        $result = $check_friendship_stmt->get_result();

        if ($result->num_rows == 0) {

            $stmt = $conn->prepare("INSERT INTO friend_requests (sender_id, recipient_id) VALUES (?, ?)");
            $stmt->bind_param("ss", $sender_id, $recipient_id);
            $stmt->execute();

            echo "Successfully added!";

        } else {
            echo "You are already friends with this person";
        }
    }
}

?>
