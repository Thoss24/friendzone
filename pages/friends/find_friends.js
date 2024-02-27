document.addEventListener('DOMContentLoaded', () => {

  let sessionData = {
    userId: 0,
    name: '',
  };
  // get user id
  $.ajax({
    url: 'http://localhost/friendzone/backend/session_data.php',
    method: 'GET',
    success: (response) => {
      //console.log(response)
      sessionData.userId = response.user_id;
      sessionData.name = response.name;
    },
  });

  const getAllUsers = () => {
    $.ajax({
      url: 'http://localhost/friendzone/backend/find_friends.php',
      method: 'GET',
      success: (response) => {

        console.log(sessionData)

        const findFriendsList = $('#friendzone_users');

        response.map((user) => {

          console.log(user)

          const viewUserProfileBtn = $(`<button class="view_user_page">View Profile</button>`); // create view profile button button

          const addFriendButton = $('<button class="add_friend_button">Add Friend</button>') // create add friend button

          viewUserProfileBtn.on('click', () => {
            window.location = `/friendzone/pages/users/user_profile.html?id=${user[0]}`; // add event to dynamically created button
          });

          addFriendButton.on("click", () => {

            const friendReqInfo = {
              userId: sessionData.userId,
              recipientId: user[0],
            };

            $.ajax({
              url: 'http://localhost/friendzone/backend/find_friends.php', // add friend http request
              method: 'POST',
              data: JSON.stringify(friendReqInfo)
            });

          });

          const userShell = // create user shell
          $(`<li class="user_shell"> 
              <h3>${user[1]}</h3>
          </li>`);

          findFriendsList.append(userShell[0]); // append user shell to container
          userShell.append(viewUserProfileBtn); // append view user profile button to user shell
          userShell.append(addFriendButton); // append add friend button to use shell

        });
      },
    });
  };
  getAllUsers();

});
