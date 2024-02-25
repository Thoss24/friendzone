<?php

require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $stmt = $conn->prepare("SELECT p.*, person.name FROM post p JOIN person WHERE p.user_id = person.user_id ORDER BY p.created_at DESC");
    $stmt->execute();

    $all_posts = $stmt->get_result();
    $all_posts_data = $all_posts->fetch_all();

    echo json_encode($all_posts_data);
}

?>