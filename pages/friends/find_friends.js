document.addEventListener("DOMContentLoaded", () => {
  const getAllUsers = () => {
    $.ajax({
      url: "http://localhost/friendzone/backend/friends.php",
      method: "GET",
      success: (response) => {
        const findFriendsList = $("#friendzone_users");

        response.map((user) => {
          let viewUserProfileBtn = `<button class="view_user_page">View Profile</button>`;
          $(".view_user_page").on("click", () => {
            window.location = `http://localhost/friendzone/pages/users/user_profile.html?id=${user[0]}`;
          });

          let userShell = `<div>
                        <h3>${user[1]}</h3>
                        ${viewUserProfileBtn}
                    </div>`;

          findFriendsList.append(userShell);

        });
        console.log($(".view_user_profile"));
      },
    });
  };
  getAllUsers();

  // view user profile

  // viewUserProfileBtn.on('click', () => {
  //     window.location = `http://localhost/friendzone/pages/users/user_profile.html?id=`
  // });
});
