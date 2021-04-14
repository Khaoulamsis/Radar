$(document).ready(function () {

    $.ajax({
        url: 'controller/FiliereController.php',
        type: 'POST',
        data: {op: ''},
        success: function(data) {
            var test = '<option value="0">Tous les Filieres</option>';

            for (i=0;i<data.length;i++) {
                test += '<option value=' + data[i].id + '>' + data[i].code + '</option>';
            };
            $("#id").html(test);

            
        },
        error: function(data, jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }


    });



    $.ajax({
        url: 'controller/cherchliste.php',
        data: {op: '', fil: 0},
        type: 'POST',
        success: function (data, textStatus, jqXHR) {
            remplir(data);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }
    });

    $('#id').on('change', function() {
        $.ajax({
            url: 'controller/cherchliste.php',
            data: {op: '', fil: this.value},
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                remplir(data);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
      });

    
    function remplir(data) {
        var contenu = $('#table-content');
        var ligne = "";
        for (i = 0; i < data.length; i++) {
            ligne += '<tr><th scope="row">' + data[i].id_classe + '</th>';
            ligne += '<td>' + data[i].code + '</td>';
            ligne += '<td>' + data[i].fil + '</td>';
            ligne += '<td hidden>' + data[i].id + '</td>';
        }
        contenu.html(ligne);
    }

});


