<?php 

require '../../backend/secure.php';

//print_r($_SESSION)

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
        <section id="profile_images_section">
        <div>
            <img src="" alt="">
            Profile Image
        </div>
        <div>
            <img src="" alt="">
            Banner Image
        </div>
        </section>
        <nav>
            <button>Update Info</button>
            <button><a href="http://localhost/friendzone/pages/friends/find_friends.html">Find Friends</a></button>
            <button><a href="http://localhost/friendzone/pages/friends/friends_list.html">My Friends</a></button>
            <button id="friend_requests_btn"><a href="http://localhost/friendzone/pages/friends/pending_requests.html">Pending Requests</a></button>
            <div>
            <button id="notification_button">Notifications</button>
            <div id="notification_modal" title="Notification dialog">
                <h3>Notifications</h3>
                <ul id="notifications_list">

                </ul>
            </div>
            </div>
           <button id="logout_button">Logout</button>
        </nav>
    </header>
    <main id="homepage_main_content_area">
        <aside id="personal_info_section">
            <h2>Personal Info Here</h2>
        </aside>
        <section id="posts_area">
            <div id="create_post_section">
                <textarea name="post" id="post_text_area" cols="30" rows="5" maxlength="280" placeholder="Whats on your mind?"></textarea>
                <div id="create_post_utility">
                <button id="create_post_btn">Post</button>
                </div>
            </div>
            <div id="existing_posts_area">
                <!-- posts go here -->
            </div>
        </section>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./homepage.js"></script>
</body>
</html>