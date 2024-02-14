<?php

require 'db_connect.php';

session_start();

$session_data = $_SESSION;

echo json_encode($session_data);

?>