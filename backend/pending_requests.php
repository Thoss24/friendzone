<?php

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    session_start();

    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare('SELECT friend_requests.friend_request_id, friend_requests.sender_id, friend_requests.recipient_id, person.name FROM friend_requests JOIN person WHERE recipient_id = ? AND friend_requests.sender_id = person.user_id');
    $stmt->bind_param("s", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $result_data = $result->fetch_all();

    echo json_encode($result_data);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();

    $request_data = json_decode(file_get_contents("php://input"), true);

    $req_sender_id = $request_data['userId'];
    $req_recipient_id = $request_data['recipientId'];
    $status = $request_data['status'];
    $req_id = $request_data['friendReqId'];
    $recipient_name = $_SESSION['name'];

    $stmt = $conn->prepare('SELECT * FROM friend_requests WHERE ? = friend_request_id');
    $stmt->bind_param("s", $req_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $req_response = $result->fetch_assoc();

    // if request successful because friendship does not already exist
    if ($stmt->affected_rows > 0) {

        $check_friendship_stmt = $conn->prepare(
        'SELECT * FROM friendship
        WHERE ? = person_id1 AND ? = person_id2 
        OR ? = person_id2 AND ? = person_id1');

        $check_friendship_stmt->bind_param("ssss", $req_recipient_id, $req_sender_id, $req_recipient_id, $req_sender_id);
        $check_friendship_stmt->execute();

        $result = $check_friendship_stmt->get_result();

    if ($result->num_rows == 0) {
    
        $stmt = $conn->prepare('UPDATE friend_requests SET status = ? WHERE ? = friend_request_id');
        $stmt->bind_param("ss", $status, $req_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0 && $status == 'accepted') {
            // accept request and create new friendship in friendship table
    
            $stmt = $conn->prepare('INSERT INTO friendship (person_id1, person_id2) VALUES (?, ?)');
            $stmt->bind_param("ss", $req_sender_id, $req_recipient_id);
            $stmt->execute();
    
            $archive_request_stmt = $conn->prepare('INSERT INTO expired_friend_requests (sender_id, recipient_id, status, recipient_name) SELECT ?, ?, ?, ?');
            $archive_request_stmt->bind_param("ssss", $req_sender_id, $req_recipient_id, $status, $recipient_name);
            $archive_request_stmt->execute();

            echo "successfully accepted the request";
    
            if ($archive_request_stmt->affected_rows > 0) {

                $delete_friend_request_stmt = $conn->prepare('DELETE FROM friend_requests WHERE friend_request_id = ?');
                $delete_friend_request_stmt->bind_param("s", $req_id);
                $delete_friend_request_stmt->execute();

            } else {
                echo "Something went wrong accepting the request";
            }
    
        } else if ($stmt->affected_rows > 0 && $status == 'rejected') {     
            // reject request to later be given feedback that the request was rejected in notification page
            // create a notification page to highlight all accepted and rejected requests

            $archive_request_stmt = $conn->prepare('INSERT INTO expired_friend_requests (sender_id, recipient_id, status, recipient_name) SELECT ?, ?, ?, ?');
            $archive_request_stmt->bind_param("ssss", $req_sender_id, $req_recipient_id, $status, $recipient_name);
            $archive_request_stmt->execute();

            if ($archive_request_stmt->affected_rows > 0) {

                $delete_friend_request_stmt = $conn->prepare('DELETE FROM friend_requests WHERE friend_request_id = ?');
                $delete_friend_request_stmt->bind_param("s", $req_id);
                $delete_friend_request_stmt->execute();

            } else {
                echo "Something went wrong declining the request";
            }
        } 
        else {
            echo "failure accepting or declining the request";
        }
        } 
    }
    else {
        echo "You are already friends with this person.";
    }


}

?>