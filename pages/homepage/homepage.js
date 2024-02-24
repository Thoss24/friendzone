document.addEventListener("DOMContentLoaded", () => {

  // global user session data
  let sessionData = {
    userId: 0,
    name: "",
    notificationsArr: [],
    notificationLength: 0,
    activePostId: 0
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

  // get notifications
  $.ajax({
    url: "http://localhost/friendzone/backend/notifications.php",
    method: "GET",
    success: (response) => {
      for (const i in response) {
        sessionData.notificationsArr[i] = response[i];
      }
      sessionData.notificationLength = response.length;
      const notificationsBtn = $("#notification_button");
      const numOfNotificationsElement = $("<strong>").attr('id', 'number_of_requests');
      const numberOfRequests =
        sessionData.notificationLength >= 1
          ? sessionData.notificationLength
          : '';
      numOfNotificationsElement.text(`${numberOfRequests}`);
      notificationsBtn.append(numOfNotificationsElement);
    },
  });

  // get pending requests
  const getPendingRequests = () => {
    $.ajax({
      url: "http://localhost/friendzone/backend/pending_requests.php",
      method: "GET",
      dataType: "json",
      success: (response) => {
        const friendRequestsBtn = $("#friend_requests_btn");
        const numOfRequestsElement = $("<strong>");
        const numberOfRequests = response.length;
        numOfRequestsElement.text(`: ${numberOfRequests}`);
        friendRequestsBtn.append(numOfRequestsElement);
      },
    });
  };
  getPendingRequests();

  const logout = () => {
    $.ajax({
      url: "http://localhost/friendzone/backend/end_session.php",
      type: "GET",
      success: (response) => {
        window.location =
          "http://localhost/friendzone/pages/login_and_create_acc/login_page.php";
      },
    });
  };

  $("#logout_button").on("click", logout);


  // create comments for post
  $('#create_comment_btn').on("click", () => {

    console.log(sessionData.activePostId)

    const comment = $('#comment_text_area');

    const commentData = {
      userId: sessionData.userId,
      comment: comment.val(),
      postId: sessionData.activePostId
    };

    $.ajax({
      url: `http://localhost/friendzone/backend/posts_and_comments.php?id=${commentData.postId}`,
      method: 'POST',
      dataType: 'json',
      data: JSON.stringify(commentData),
      success: (response) => {
        console.log(response)
      }
    })

  })

  // get comments for post
  const getCommentsAndPostData = (postId) => {

    console.log(postId)

    $.ajax({
      url: `http://localhost/friendzone/backend/posts_and_comments.php?id=${postId}`,
      method: 'GET',
      success: (response) => {
        console.log(response)
        // display post info and comments for post
      },
      error: (error) => [
        console.log(error)
      ]
    })
    
  };

  // make new post
  const makePost = () => {
    let post = $("#post_text_area");

    let postObj = { post: post.val(), user_id: sessionData.userId };

    $.ajax({
      url: "http://localhost/friendzone/backend/posts.php",
      method: "POST",
      dataType: "text",
      data: JSON.stringify(postObj),
      success: (response) => {
        getPosts();
      },
      error: (error) => {
        console.log(error);
      },
    });
  };

  // add posts to page
  $("#create_post_btn").on("click", makePost);

  const getPostsOnPageLoad = () => {
    $.ajax({
      url: "http://localhost/friendzone/backend/posts.php",
      method: "GET",
      dataType: "json",
      success: (response) => {
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
            console.log(post)
            const postTime = post[3];
            const postContent = post[2];
            const postId = post[0];

            const postShell = $('<div>').addClass('post_shell');

            const postShellContent = $(`
            <div class="post_header">
              <div class="post_name_and_date">
                <h3>${sessionData.name}</h3>
                <p>${postTime}</p>
              </div>
            </div>
            <div class="post_content"><p>${postContent}</p></div>`
          );

          postShell.append(postShellContent)

          postShell.on("click", () => {
            const postModal = $('.post_modal_container');
            postModal.css("display", "flex");
            sessionData.activePostId = postId
            getCommentsAndPostData(postId)
          })

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

  // get posts
  const getPosts = () => {
    $.ajax({
      url: "http://localhost/friendzone/backend/posts.php",
      method: "GET",
      dataType: "json",
      success: (response) => {
        console.log(response)
        const postsContainer = $("#existing_posts_area");
        const mostRecentPost = response[response.length - 1];

        const postContent = mostRecentPost[2];
        const postTime = mostRecentPost[3];
        const postId = mostRecentPost[0];

        const postShell = $(`<div id=${postId} class="post_shell">
        <div class="post_header">
          <div class="post_name_and_date">
            <h3>${sessionData.name}</h3>
            <p>${postTime}</p>
          </div>
        </div>
        <div class="post_content"><p>${postContent}</p></div>
        </div>`);

        $(`#${postId}`).on("click", () => {
          const postModal = $('.post_modal_container');
          postModal.css("display", "flex");
          sessionData.activePostId = postId
          getCommentsAndPostData(postId)
        })
        postsContainer.append(postShell);
      },
      error: (error) => {
        console.log(error);
      },
    });
  };

  // notification display handler logic
  $("#notification_button").on("click", () => {
    let offset = $("#notification_button").offset();
    let height = $("#notification_button").height();
    let width = $("#notification_button").width();
    let top = offset.top + height + 5 + "px";
    let right = offset.left + width + "px";

    const notificationList = $("#notifications_list");
    const modal = $("#notification_modal");

    modal.css({
      display: modal.css("display") === "flex" ? "none" : "flex",
      position: "absolute",
      top: top,
    });

    const notifications = sessionData.notificationsArr.filter(
      (item) => item[5] !== 1
    );

    notificationList.empty();

    notifications.map((item) => {
      console.log(item);

      const notificationId = item[0];
      const friendReqStatus = item[3];
      const recipientName = item[6];

      const notificationMessage = `Friend request ${friendReqStatus} by ${recipientName}`;

      const notificationShell = $("<div>").addClass("notification_shell");
      const notificationDescription = $("<p>").text(notificationMessage);
      const clearNotificationBtn = $("<button>").text("X");

      clearNotificationBtn.css({
        border: "none",
        "border-radius": "14px",
        "background-color": "lightgrey",
        padding: "2px",
        fontSize: "10px",
        display: "flex",
        "justify-content": "center",
        "align-items": "center",
      });

      clearNotificationBtn.on("click", () => {
        $.ajax({
          url: `http://localhost/friendzone/backend/notifications.php?id=${notificationId}`,
          method: "PATCH",
          success: () => {

            sessionData.notificationsArr[0][5] = 1;
            notificationShell.remove();

            sessionData.notificationLength--;
            console.log(sessionData.notificationLength)
            const numOfNotificationsElement = $('#number_of_requests');

            const numberOfRequests =
              sessionData.notificationLength >= 1
                ? sessionData.notificationLength
                : '';

            console.log(numberOfRequests)
            numOfNotificationsElement.text(`${numberOfRequests}`);
            console.log(numOfNotificationsElement[0])
          },
        });
      });

      notificationShell.css({
        display: "flex",
        fontSize: "12px",
        gap: "5px",
        margin: "4px",
      });

      notificationShell.append(notificationDescription);
      notificationShell.append(clearNotificationBtn);
      notificationList.append(notificationShell);
    });

    $("#notifications_list");
  });

  // click document body to hide notification modal
  $(document).on("mouseup", (e) => {
    const modal = $("#notification_modal");
    const notificationBtn = $("#notification_button");
    if (modal.has(e.target).length === 0) {
      modal.css("display", "none");
    }
  });


  // get comments for post


  // hide post handler
  $('#close_modal_btn').on("click", () => {
    const postModal = $('.post_modal_container');
    postModal.css("display", "none");
  })

});
