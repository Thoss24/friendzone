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

?>