<?php
    require 'db_connect.php';

    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $entered_password = $_POST['password'];
    $username = $_POST['username'];
    $stmt = $conn->prepare("SELECT password FROM person WHERE username = ?");
    
    if (password_verify($entered_password, $hashed_password)) {
      

    }
?>