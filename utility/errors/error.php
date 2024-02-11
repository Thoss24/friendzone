<?php
    session_start();
    print_r($_SESSION);
    $err = $_SESSION['auth_error'];
?>

<!DOCTYPE html>
<html lang="en">
<head> 

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let backToLogin = $('#back_to_login');
            backToLogin.on('click', () => {
                $.ajax({
                    url: "http://localhost/friendzone/backend/end_session.php",
                    type: "GET",
                    success: (response) => {
                        window.location = "http://localhost/friendzone/pages/login_and_create_acc/login_page.php"
                        console.log(response)
                    }
                })
            })

        })
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error!</title>
</head>
<body>

    <section>
        <div>
            <h3>Something went wrong!</h3>
            <?php echo "<p>${err}</p>"?>
            <button id="back_to_login">Go back to Log in page</button>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>