document.addEventListener("DOMContentLoaded", () => {
   
    $('#login_form').on('submit', (e) => {
        e.preventDefault()
        login()
    });

    $('#create_acc_form').on('submit', (e) => {
        e.preventDefault()
        createAccount()
    });

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
                console.log(response)
                window.location = "http://localhost/friendzone/pages/homepage/homepage.php"
            },
            error: (err) => {
                const errorCode = err.status;
                const message = err.responseJSON.message

                alert(`Error ${errorCode}. ${message}`)
            }
        });
    };

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
                const message = err.responseJSON.message

                alert(`Error ${errorCode}. ${message}`)
            }
        });
    }
})