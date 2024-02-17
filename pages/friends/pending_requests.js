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
               
            }
        })
    }
    getPendingRequests()
  
  });
  