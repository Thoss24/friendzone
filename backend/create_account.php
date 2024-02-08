<?php

    require 'db_connect.php';

    $request_data = json_decode(file_get_contents('php://input'), true);

    $email = $request_data['email'];
    $name = $request_data['name'];

    $stmt = $conn->prepare("SELECT email FROM person WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_msg = "User ${email} already exists";
        echo json_encode($error_msg);
    } else {
        $password = $request_data['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO person (email, password, name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $password, $name);
        $stmt->execute();

        $success_msg = "User ${email} successfully added!";
        echo json_encode($success_msg);
    }

?>