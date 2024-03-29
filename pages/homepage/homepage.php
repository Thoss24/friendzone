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
    <div id="container">
        <!-- start post modal -->
        <div class='post_modal_container'>
            <dialog open id='modal_window'>
                <section>
                    <div>
                        <h3 id="user_post_name"></h3>
                        <p id="user_post_date"></p>
                    </div>
                    <p id="user_post_text"></p>
                </section>
                <p id="modal_message"></p><br>
                <div id="create_post_section">
                    <textarea name="post" id="comment_text_area" cols="30" rows="4" maxlength="250" placeholder="Add comment."></textarea>
                    <div id="create_post_utility">
                        <button id="create_comment_btn">Add comment</button>
                    </div>
                </div>
                <div id="existing_comments">
                </div>
                <button id='close_modal_btn'>Close</button>
            </dialog>
        </div>
        <!-- end post modal -->
        <!-- start header section -->
        <header>
            <nav id="nav_section">
                <button>Update Info</button>
                <button><a href="http://localhost/friendzone/pages/friends/find_friends.html">Find Friends</a></button>
                <button><a href="http://localhost/friendzone/pages/friends/friends_list.html">My Friends</a></button>
                <button><a href="http://localhost/friendzone/pages/feed/feed.html">My Feed</a></button>
                <button id="friend_requests_btn"><a href="http://localhost/friendzone/pages/friends/pending_requests.html">Pending Requests</a></button>
                <div>
                    <button id="notification_button">Notifications</button>
                    <div id="notification_modal" title="Notification dialog">
                        <h3 id="notifications_interface">Notifications</h3>
                        <ul id="notifications_list">

                        </ul>
                    </div>
                </div>
                <button id="logout_button">Logout</button>
            </nav>
        </header>
        <!-- end header section  -->
        <!-- start main content body section -->
        <main id="homepage_main_content_area">
            <aside id="personal_info_section">
                <h2>About</h2>
                <form action="">
                    <div class="personal_info_section_shell">
                        <label for="name">Name</label>
                        <input type="text">
                    </div>
                    <div class="personal_info_section_shell">
                        <label for="email">Email</label>
                        <input type="email">
                    </div>
                    <div class="personal_info_section_shell">
                        <label for="biography">Biography</label>
                        <textarea type="biography" cols="25" rows="5" maxlength="500"></textarea>
                    </div>
                    <div class="personal_info_section_shell">
                        <label for="phone_number">Phone number</label>
                        <input type="phone_number">
                    </div>
                    <button type="submit" id="done_editing_info_btn">Done</button>
                    <button type="button" id="edit_info_btn">Edit</button>
                </form>
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
    </div>
    <!-- end main content body section -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./homepage.js"></script>
</body>

</html>