document.addEventListener("DOMContentLoaded", () => {

  let sessionData = {
    userId: 0,
    name: "",
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

  const getPendingRequests = () => {
    $.ajax({
        url: 'http://localhost/friendzone/backend/pending_requests.php',
        method: 'GET',
        dataType: 'json',
        success: (response) => {
          const friendRequestsBtn = $('#friend_requests_btn');
          const numOfRequestsElement = $('<strong></strong>');
          const numberOfRequests = response.length;
          numOfRequestsElement.text(`: ${numberOfRequests}`);
          friendRequestsBtn.append(numOfRequestsElement)
        }
    })
  }
  getPendingRequests()

  const logout = () => {
    $.ajax({
      url: "http://localhost/friendzone/backend/end_session.php",
      type: "GET",
      success: (response) => {
        window.location =
          "http://localhost/friendzone/pages/login_and_create_acc/login_page.php";
        console.log(response);
      },
    });
  };

  $("#logout_button").on("click", logout);

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

  $("#create_post_btn").on("click", makePost);

  const getPostsOnPageLoad = () => {
    $.ajax({
      url: "http://localhost/friendzone/backend/posts.php",
      method: "GET",
      dataType: "json",
      success: (response) => {
        let noPosts = $('<div id="no_posts"><h3>No posts to show</h3></div>');
        let postsContainer = $("#existing_posts_area");

        if (response.length === 0) {
          postsContainer.append(noPosts);
        } else {
          // remove no posts element when section is populated by existing posts
          $("#no_posts").remove();
          // render each post on the page
          postsContainer.empty();
          response.map((post) => {
            let postShell = $(`<div>
            <div id="post_header">
              <img>
              <div id="post_name_and_date">
                <h3>${sessionData.name}</h3>
                <p>${post[3]}</p>
              </div>
            </div>
            <div><p>${post[2]}</p></div>
          </div>`);

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
    console.log("Get posts");
    $.ajax({
      url: "http://localhost/friendzone/backend/posts.php",
      method: "GET",
      dataType: "json",
      success: (response) => {
        let postsContainer = $("#existing_posts_area");

        let mostRecentPost = response[response.length - 1];

        console.log(mostRecentPost)

        let postShell = $(`<div>
          <div id="post_header">
            <img>
            <div id="post_name_and_date">
              <h3>${sessionData.name}</h3>
              <p>${mostRecentPost[3]}</p>
            </div>
          </div>
          <div><p>${mostRecentPost[2]}</p></div>
        </div>`);

        postsContainer.append(postShell);
      },
      error: (error) => {
        console.log(error);
      },
    });
  };

  
});
