<?php

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $post_id = $_GET['id'];
    
    $stmt = $conn->prepare(
    'SELECT p.post_id, p.post_content, p.created_at, pc.comment, pc.comment_id, pc.user_id, person.name 
    FROM post p 
    JOIN post_comment pc ON p.post_id = pc.post_id
    JOIN person ON person.user_id = pc.user_id
    WHERE p.post_id = ?');

    $stmt->bind_param("s", $post_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $result_data = $result->fetch_all();

    echo json_encode($result_data);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $request_data = json_decode(file_get_contents('php://input', true));

    $user_id = $request_data->userId;
    $comment = $request_data->comment;
    $post_id = $request_data->postId;

    $stmt = $conn->prepare('INSERT INTO post_comment (comment, user_id, post_id) VALUES (?, ?, ?)');
    $stmt->bind_param("sss", $comment, $user_id, $post_id);
    $stmt->execute();

    $result = $stmt->get_result();

    echo "success";

}

?>