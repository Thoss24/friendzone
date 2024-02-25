<?php

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $user_id = $_GET['id'];

    $stmt = $conn->prepare(
    "SELECT p.*, person.name
    FROM post p 
    JOIN person WHERE p.user_id = person.user_id AND p.user_id = ? ORDER BY created_at DESC");

    $stmt->bind_param("s", $user_id);
    $stmt->execute();

    $user_posts = $stmt->get_result();
    $all_user_posts_data = $user_posts->fetch_all();

    echo json_encode($all_user_posts_data);
}

?>