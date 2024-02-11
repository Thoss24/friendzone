<?php

session_start();

if ($_SESSION['id'] != session_id() || !$_SESSION['logged_in'] || !isset($_SESSION['logged_in'])) {
    echo session_id() ."\n" ."<br>";
    echo $_SESSION['id'] ."\n" ."<br>";
    echo $_SESSION['logged_in'] ."\n" ."<br>";
    echo isset($_SESSION['logged_in']) ."\n" ."<br>";
    //session_destroy();

    $_SESSION['auth_error'] = 'Error code: 401. Invalid credentials.';
    header('Location:/friendzone/utility/errors/error.php');
    exit;
} 

?>