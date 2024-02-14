<?php

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $request_data = json_decode(file_get_contents("php://input"), true);
    $post = $request_data['post'];
    $user_id = $request_data['user_id'];

    $stmt = $conn->prepare("INSERT INTO post (post_content, user_id) VALUES (?, ?)");
    $stmt->bind_param("ss", $post, $user_id);
    $stmt->execute();

}

?>