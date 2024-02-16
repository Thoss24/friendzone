<?php

    require 'db_connect.php';

    $request_data = json_decode(file_get_contents("php://input"), true);

    $entered_password = $request_data['password'];
    $hashed_password = password_hash($entered_password, PASSWORD_DEFAULT);
    
    $email = $request_data['email'];
    $stmt = $conn->prepare("SELECT password, name, user_id FROM person WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $result_data = $result->fetch_assoc();

    if ($result->num_rows == 1) {

        $user_id = $result_data['user_id'];
        $name = $result_data['name'];
        $hashed_password = $result_data['password'];

        if (password_verify($entered_password, $hashed_password)) {
            $response = array(
                'success'=>true,
                'message'=> 'Email and password are correct. User authorization successful',
                'data'=> array(
                    'user_id'=> $user_id,
                    'name'=> $name,
                )
            );

            session_start();
            session_regenerate_id(true);
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['logged_in'] = true;
            $_SESSION['id'] = session_id();
    
            $json_response = json_encode($response);
    
            echo $json_response;
        } else {
            $response = array(
                'success'=> false,
                'message'=> 'Email and or password are incorrect. Login attempt unsuccessful',
            );

            http_response_code(401);
            $json_response = json_encode($response);
    
            echo $json_response;
        }

    } else if ($result->num_rows == 0){
        $response = array(
            'success'=>false,
            'message'=> 'A user with that email address does not exist',
            'data'=> array(
                'email'=> $email
            )
        );

        http_response_code(401);
        $json_response = json_encode($response);

        echo $json_response;
    } 


    
?>