document.addEventListener("DOMContentLoaded", () => {

    const logout = () => {
        $.ajax({
            url: "http://localhost/friendzone/backend/end_session.php",
            type: "GET",
            success: (response) => {
                window.location = "http://localhost/friendzone/pages/login_and_create_acc/login_page.php"
                console.log(response)
            }
        })
    };

    $('#logout_button').on('click', logout)

});
