<?php

// check query string for error=1 & if it exists display some message saying authentication failed
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="login_and_create_acc.css" rel="stylesheet"></link>
    <title>FriendZone Login</title>
</head>
<body>
    <main>
        <section>
            <div>
            <h1>FriendZone</h1>
            <p>FriendZone is a social media app clone that helps you to connect and share with other people.</p>
            </div>
        <form action="" method="POST" id="login_form">
            <fieldset>
                <input type="email" id="login_email" placeholder="Email address" autocomplete="username">
            </fieldset>
            <fieldset>
                <input type="password" id="login_password" placeholder="Password" autocomplete="current-password">
            </fieldset>
            <fieldset>
            <button type="submit" id="login_button">Log in</button>
            </fieldset>
            <fieldset>
            <button type="button" id="create_account_button"><a href="http://localhost/friendzone/pages/login_and_create_acc/create_account.html">Create New Account</a></button>
            </fieldset>
        </form>
        </section>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./login_create_acc.js"></script>
</body>
</html>