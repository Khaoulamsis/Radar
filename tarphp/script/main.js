
$(document).ready(function () {
    var main = $('#main-content');
    var doc = $(this);
    var email = $("#email");
    var password = $("#password");
    var check = $("#checkLogin");
    var btn = $("#connect");
    email.val('');
    password.val('');
    $(".filiere").click(function () {
        main.load("./pages/filiere.php");
    });
    $(".classe").click(function () {
        main.load("./pages/classe.php");
    });
    $(".statistiques").click(function () {
        main.load("../pages/statistiques.php");
    });

    $(document).keypress(function (e) {
        if (e.which == 13) {
            btn.click();
        }
    });
    function redirect(data) {
        $.ajax({
            url: './login.php',
            data: {email: data.email, photo: data.photo, employe: data.cin, role: data.role, nom: data.nom},
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                location.href = './index.php';
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    }
});
