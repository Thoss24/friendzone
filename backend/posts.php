<?php

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $request_data = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare("INSERT INTO post (post_content, user_id) VALUES (?, ?)");
    $post = $request_data['post'];
    $user_id = $request_data['user_id'];
    $stmt->bind_param('ss', $post, $user_id);
    $stmt->execute();

    echo "Post successfully created";
}
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    session_start();

    $stmt = $conn->prepare("SELECT * FROM post WHERE user_id = ? ORDER BY created_at DESC");
    $user_id = $_SESSION['user_id'];
    $stmt->bind_param("s", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $result_data = $result->fetch_all();

    echo json_encode($result_data);
}

?>