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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $request_data = json_decode(file_get_contents("php://input"), true);

   $status = $request_data['status'];
   $req_id = $request_data['friendReqId'];

   $stmt = $conn->prepare('SELECT status, sender_id, recipient_id FROM friend_requests WHERE ? = friend_request_id');
   $stmt->bind_param("s", $req_id);
   $stmt->execute();

   $result = $stmt->get_result();
   $req_response = $result->fetch_assoc();

   $req_status = $req_response['status'];
   $req_recipient_id = $req_response['recipient_id'];
   $req_sender_id = $req_response['sender_id'];

   if ($req_status == 'accepted') {
    echo "You are already friends with this person.";
   } 
   else if ($req_status == 'rejected') {
    echo "You have already rejected this request.";
   } 
   else {
    $stmt = $conn->prepare('UPDATE friend_requests SET status = ? WHERE ? = friend_request_id');
    $stmt->bind_param("ss", $status, $req_id);
    $stmt->execute();

    // if the request status has not already been accepted or rejected - accept request and create new friendship in friendship table
    if ($stmt->affected_rows > 0 && $status == 'accepted') {
        echo "successfully accepted the request";

        $stmt = $conn->prepare('INSERT INTO friendship (person_id1, person_id2) VALUES (?, ?)');
        $stmt->bind_param("ss", $req_sender_id, $req_recipient_id);
        $stmt->execute();

    } 
    // if the request status has not already been accepted or rejected - reject request - to later be given feedback that request was rejected in notification page
    else if ($stmt->affected_rows > 0 && $status == 'rejected') {
        // create a notification page to highlight all accepted and rejected requests
        echo "successfully rejected the request";
    } 
    else {
        echo "failure";
    }

}
}

?>