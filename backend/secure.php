<?php

session_start();

if ($_SESSION['id'] != session_id() || !$_SESSION['logged_in'] || isset($_SESSION['logged_in'])) {
    session_destroy();
    header('Location: login_page.html?error=1');
    exit;
} 

?>