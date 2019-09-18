$(function () {
    $('#btnSignIn').click(function () {
        login();
    });
});


function login() {
    var username = $('#inputEmail').val();
    var password = $('#inputPassword').val();
    var data = {
        "username": username,
        "password": password
    };
    $.ajax({
        url: 'login.php',
        data: data,
        type: 'POST',
        success: function (response) {
            if (response == 0){
                location.href = "fileUpload/fileUpload.php";
            } else {
                alert("Wrong Username/Password");
            }
        }
    });
}
