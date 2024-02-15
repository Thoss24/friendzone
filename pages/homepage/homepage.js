document.addEventListener("DOMContentLoaded", () => {
  let sessionData = {
    userId: 0,
  };
  // get user id
  $.ajax({
    url: "http://localhost/friendzone/backend/session_data.php",
    method: "GET",
    success: (response) => {
      sessionData.userId = response.user_id;
    },
  });

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
        getPosts()
      },
      error: (error) => {
        console.log(error)
      }
    });
  };

  $("#create_post_btn").on("click", makePost);

  // get posts
  const getPosts = () => {
    console.log("Get posts")
    $.ajax({
      url: "http://localhost/friendzone/backend/posts.php",
      method: "GET",
      dataType: "json",
      success: (response) => {
        console.log(response)
      }, 
      error: (error) => {
        console.log(error)
      }
    })
  }
  
});
