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
  
    const getPendingRequests = () => {
        $.ajax({
            url: 'http://localhost/friendzone/backend/pending_requests.php',
            method: 'GET',
            dataType: 'json',
            success: (response) => {
                console.log(response)
                // <ul id="pending_requests_list">
            
                // </ul>

                const pendingFriendRequestsList = $('#pending_requests_list');

                response.map((req) => {

                  const friendReqId = req[0];
                  const userId = req[1];
                  const userName = req[2];

                  const requestShell = 
                  $(`<li class="pending_request_shell"><h3>${userName}</h3></li>`);

                  const acceptReqBtn = $('<button class="accept_req_btn">Accept</button>');
                  const declineReqBtn = $('<button class="decline_req_btn">Decline</button>');

                  acceptReqBtn.on("click", () => {

                    const requestResponse = {
                      friendReqId,
                      status: 'accepted'
                    };

                    $.ajax({
                      url: 'http://localhost/friendzone/backend/pending_requests.php',
                      method: 'POST',
                      dataType: 'json',
                      data: JSON.stringify(requestResponse)
                    });

                  });

                  declineReqBtn.on("click", () => {

                    const requestResponse = {
                      friendReqId,
                      status: 'rejected'
                    };

                    $.ajax({
                      url: 'http://localhost/friendzone/backend/pending_requests.php',
                      method: 'POST',
                      dataType: 'json',
                      data: JSON.stringify(requestResponse)
                    });

                  });

                  requestShell.append(declineReqBtn);
                  requestShell.append(acceptReqBtn);
                  pendingFriendRequestsList.append(requestShell);

                });
            }
        })
    }
    getPendingRequests()
  
  });
  