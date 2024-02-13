document.addEventListener("DOMContentLoaded", () => {

    $('#create_acc_form').on('submit', (e) => {
        e.preventDefault()
        createAccount()
    });

    // handle user create account
    const createAccount = () => {

        const email =  $('#create_acc_email')[0]
        const password = $('#create_acc_password')[0]
        const name = $('#create_acc_name')[0]

        const user = {
            name: name.value,
            email: email.value,
            password: password.value
        };

        $.ajax({
            url: "http://localhost/friendzone/backend/create_account.php",
            method: 'POST',
            dataType: "json",
            data: JSON.stringify(user),
            success: (response) => {

                let successContainer = $('#modal_container');
                let successMessage = $('#modal_message');
                let successTitle = $('#modal_title');
                let successPrompt = $('#modal_prompt');

                successContainer.css("display", "flex");
                successTitle.text("Account successfully created!");
                successMessage.text(response.message);
                successPrompt.text("Continue to login page?");

                let authSuccessBtn = $('#close_modal_btn');
                let authSuccessContainer = $('#modal_container');
            
                authSuccessBtn.on('click', () => {
                    authSuccessContainer.css("display", "none");
                    window.location = "http://localhost/friendzone/pages/login_and_create_acc/login_page.php"
                });
            },
            error: (err) => {

                const message = err.responseJSON.message

                let errContainer = $('#modal_container');
                let errMessage = $('#modal_message');
                let errTitle = $('#modal_title');
                let errPrompt = $('#modal_prompt')

                errContainer.css("display", "flex");
                errTitle.text("Something went wrong!");
                errMessage.text(message);
                errPrompt.text("Please try using a different email address");

                let authErrBtn = $('#close_modal_btn');
                let authErrContainer = $('#modal_container');
            
                authErrBtn.on('click', () => {
                    authErrContainer.css("display", "none");
                });
            }
        });
    };

    $('#login_form').on('submit', (e) => {
        e.preventDefault()
        login()
    });

    // handle user login
    const login = () => {
        const email =  $('#login_email')[0]
        const password = $('#login_password')[0]

        const user = {
            email: email.value,
            password: password.value
        };

        $.ajax({
            url: "http://localhost/friendzone/backend/authorization.php",
            method: 'POST',
            dataType: "json",
            data: JSON.stringify(user),
            success: (response) => {
                console.log(response)
                window.location = "http://localhost/friendzone/pages/homepage/homepage.php"
            },
            error: (err) => {

                const errorCode = err.status;
                const message = err.responseJSON.message;

                let errContainer = $('#modal_container');
                let errMessage = $('#modal_message');

                errContainer.css("display", "flex");
                errMessage.text(`Error ${errorCode}. ${message}.`);

                let authErrBtn = $('#close_modal_btn');
                let authErrContainer = $('#modal_container');
            
                authErrBtn.on('click', () => {
                    authErrContainer.css("display", "none");
                });
            }
        });
    }

    // handle session error
    let errContainer = $('#session_err_container');
    let errBtn = $('#close_session_error_btn');

    errBtn.on('click', () => {
        $.ajax({
            url: "http://localhost/friendzone/backend/end_session.php",
            type: "GET",
            success: (response) => {
                errContainer.css("display", "none")
                console.log(response)
            }
        })
    });
    
})