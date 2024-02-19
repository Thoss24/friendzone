<?php

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    session_start();

    $curr_user_id = $_SESSION['user_id'];
    $curr_user_email = $_SESSION['email'];

    // $stmt = $conn->prepare('SELECT friend_requests.friend_request_id, friend_requests.sender_id, person.name FROM friend_requests JOIN person WHERE recipient_id = ? AND friend_requests.sender_id = person.user_id');

    $stmt = $conn->prepare(
    'SELECT person.name, person.user_id, person.email FROM person JOIN friendship 
    WHERE person.user_id = friendship.person_id1 AND ? = friendship.person_id2
    OR person.user_id = friendship.person_id2 AND ? = friendship.person_id1
    AND ? <> person.email');

    $stmt->bind_param("sss", $curr_user_id, $curr_user_id, $curr_user_email);
    $stmt->execute();

    $get_friends = $stmt->get_result();
    $friends = $get_friends->fetch_all();

    echo json_encode($friends);
}
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    session_start();

    $curr_user_id = $_SESSION['user_id'];
    $user_to_del_id = $_GET['id'];

    $stmt = $conn->prepare(
    'DELETE FROM friendship WHERE ? = friendship.person_id1 AND ? = friendship.person_id2
    OR ? = friendship.person_id2 AND ? = friendship.person_id1');
    $stmt->bind_param("ssss", $curr_user_id, $user_to_del_id, $curr_user_id, $user_to_del_id);

    if ($stmt->execute()) {
        echo "successfully deleted user from fiends list";
    } else {
        echo "Error deleting user: " . $stmt->error;
    }
}

?>