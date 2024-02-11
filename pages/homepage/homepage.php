<?php require '../../backend/secure.php';

session_start();

print_r($_SESSION)

// add prevent page back and forward for extra security

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>

    <h1>Home</h1>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./homepage.js"></script>
</body>
</html>