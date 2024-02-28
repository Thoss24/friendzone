document.addEventListener("DOMContentLoaded", () => {
  // global user session data
  let sessionData = {
    userId: 0,
    name: "",
    notificationsArr: [],
    notificationLength: 0,
    activePostId: 0,
  };

  // get user id
  $.ajax({
    url: "http://localhost/friendzone/backend/session_data.php",
    method: "GET",
    success: (response) => {
      //console.log(response)
      sessionData.userId = response.user_id;
      sessionData.name = response.name;
    },
  });

  // create comments for post
  const makeComment = () => {
    const comment = $("#comment_text_area");

    const commentData = {
      userId: sessionData.userId,
      comment: comment.val(),
      postId: sessionData.activePostId,
    };

    $.ajax({
      url: `http://localhost/friendzone/backend/posts_and_comments.php?id=${commentData.postId}`,
      method: "POST",
      dataType: "text",
      data: JSON.stringify(commentData),
      success: () => {
        getComments()
      },
    });
  };

  const getComments = () => {

    const existingComments = $("#existing_comments");

    $.ajax({
      url: `http://localhost/friendzone/backend/posts_and_comments.php?id=${sessionData.activePostId}`,
      method: "GET",
      success: (response) => {

        const mostRecentComment = response[response.length - 1]

        console.log(response)

        const userPosterName = $("#user_post_name");
        const userPosterText = $("#user_post_text");
        const userPostDate = $("#user_post_date");

        const pId = mostRecentComment[0];
        const postText = mostRecentComment[1];
        const postDate = mostRecentComment[2];
        const postComment = mostRecentComment[3];
        const commentId = mostRecentComment[4];
        const postCommenterId = mostRecentComment[5];
        const postCommenterName = mostRecentComment[6];

        if (sessionData.activePostId === pId) {
          userPosterName.text(sessionData.name);
          userPosterText.text(postText);
          userPostDate.text(postDate);

          const commentShell = $("<div>").addClass("comment_shell");
          const commenterName = $("<h4>").text(postCommenterName);
          const postCommentText = $("<p>").text(postComment);

          commentShell.append(commenterName);
          commentShell.append(postCommentText);
          existingComments.append(commentShell);
        }
      },
      error: (error) => {
        console.log(error);
      },
    });
  }

  $("#create_comment_btn").on("click", makeComment);

  // get comments for post
  const getCommentsAndPostData = (postId, userName) => {
    
    const existingComments = $('#existing_comments');
    existingComments.empty();

    $.ajax({
      url: `http://localhost/friendzone/backend/posts_and_comments.php?id=${postId}`,
      method: "GET",
      success: (response) => {

        console.log(response)

        const userPosterName = $('#user_post_name');
        const userPosterText = $('#user_post_text');
        const userPostDate = $('#user_post_date');

        response.map((item) => {

          console.log(item)

          const pId = item[0]
          const postText = item[1]
          const postDate = item[2]
          const postComment = item[3]
          const commentId = item[4]
          const postCommenterId = item[5]
          const postCommenterName = item[6]

          if (postId === pId) {
            userPosterName.text(userName)
            userPosterText.text(postText)
            userPostDate.text(postDate)

            const commentShell = $('<div>').addClass('comment_shell');
            const commenterName = $('<h4>').text(postCommenterName);
            const postCommentText = $('<p>').text(postComment);
  
            commentShell.append(commenterName)
            commentShell.append(postCommentText)
            existingComments.append(commentShell)
          }

        })
      },
      error: (error) => {
        console.log(error);
      },
    });
  };

  const getPostsOnPageLoad = () => {
    const queryString = window.location.search;
    const userProfileId = queryString.split("=")[1];

    $.ajax({
      url: `http://localhost/friendzone/backend/user_profile.php?id=${userProfileId}`,
      method: "GET",
      dataType: "json",
      success: (response) => {
        console.log(response)
        const noPosts = $('<div id="no_posts"><h3>No posts to show</h3></div>');
        const postsContainer = $("#existing_posts_area");

        if (response.length === 0) {
          postsContainer.append(noPosts);
        } else {
          // remove no posts element when section is populated by existing posts
          $("#no_posts").remove();
          // render each post on the page
          postsContainer.empty();
          response.map((post) => {
            console.log(post);
            const postTime = post[3];
            const postContent = post[2];
            const postId = post[0];
            const userName = post[4];

            const postShell = $("<div>").addClass("post_shell");

            const postShellContent = $(`
              <div class="post_header">
                <div class="post_name_and_date">
                  <h3>${userName}</h3>
                  <p>${postTime}</p>
                </div>
              </div>
              <div class="post_content"><p>${postContent}</p></div>`);

            postShell.append(postShellContent);

            postShell.on("click", () => {
              const postModal = $(".post_modal_container");
              postModal.css("display", "flex");
              sessionData.activePostId = postId;
              getCommentsAndPostData(postId, userName);
            });

            postsContainer.append(postShell);
          });
        }
      },
      error: (error) => {
        console.log(error);
      },
    });
  };
  getPostsOnPageLoad();

  // hide post handler
  $("#close_modal_btn").on("click", () => {
    const postModal = $(".post_modal_container");
    postModal.css("display", "none");
  });
});
