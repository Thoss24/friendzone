document.addEventListener("DOMContentLoaded", () => {
   
    $('#login_button').on('submit', () => {

    });

    $('#create_acc_button').on('click', (e) => {
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
            data: JSON.stringify(user)
        });
    };

    const login = () => {
        const email =  $('#login_email')
        const password = $('#login_password')
    }
})