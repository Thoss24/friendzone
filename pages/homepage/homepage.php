<?php 

require '../../backend/secure.php';

//print_r($_SESSION)

// add prevent page back and forward for extra security

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./homepage.css" rel="stylesheet">
    <title>Home</title>
</head>
<body>
    <header>
        <nav>
            <h3>
                <?php echo "<h3>Welcome {$_SESSION['name']}</h3>"?>
            </h3>
           <button id="logout_button">Logout</button>
        </nav>
    </header>
    <main id="homepage_main_content_area">
        <aside id="personal_info_section">
            <h2>Personal Info Here</h2>
        </aside>
        <section id="posts_area">
            <div id="make_post_section">
                <textarea name="post" id="post_text_area" cols="30" rows="5" maxlength="280" placeholder="Whats on your mind?"></textarea>
                <div>
                <button id="make_post_btn">Post</button>
                </div>
            </div>
            <div id="existing_posts_area">

            </div>
        </section>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./homepage.js"></script>
</body>
</html>