document.addEventListener("DOMContentLoaded", () => {
  const getMyFriends = () => {
    $.ajax({
      url: "http://localhost/friendzone/backend/friends.php",
      method: "GET",
      success: (response) => {
        const friendsList = $("#friends_list");

        response.map((friend) => {
          const friendShell = $("<li>").addClass("friend_shell");
          const friendName = $("<h3>").text(friend[0]);

          const deleteFriendBtn = $("<button>")
            .addClass("delete_friend_button")
            .text("Remove Friend");

          const viewUserProfileBtn = $("<button>")
            .addClass("view_friend_profile_btn")
            .text("View Profile");

          viewUserProfileBtn.on("click", () => {
            window.location = `/friendzone/pages/users/user_profile.html?id=${friend[1]}`; // add event to dynamically created button
          });

          deleteFriendBtn.on("click", () => {
            const confirmDelete = window.confirm(
              `Are you sure you want to delete ${friend[0]} from your friends list?`
            );

            if (confirmDelete) {
              $.ajax({
                url: `http://localhost/friendzone/backend/friends.php?id=${friend[1]}`,
                method: "DELETE",
              });
            }
          });

          friendShell.append(friendName);
          friendShell.append(deleteFriendBtn);
          friendShell.append(viewUserProfileBtn);
          friendsList.append(friendShell);
        });
      },
    });
  };
  getMyFriends();
});
