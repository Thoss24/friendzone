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
        
        $response = array(
            'success'=> false,
            'message'=> 'A user with that email address already exists',
            'data'=> array(
                'email'=> $email
            ),
        );

        http_response_code(401);
        $json_response = json_encode($response);

        echo $json_response;

    } else {
        $password = $request_data['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO person (email, password, name) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $hashed_password, $name);
        $stmt->execute();

        session_start();
        $_SESSION['email'] = $email;

        $success_msg = "Account {$email} successfully added!";

        $response = array(
            'success'=> true,
            'message'=> $success_msg,
            'data'=> array(
                'email'=> $email
            ),
        );

        $json_response = json_encode($response);

        echo $json_response;
    }

?>