$(document).ready(function () {

    $.ajax({
        url: 'controller/FiliereController.php',
        type: 'POST',
        data: {op: '' , fil : 0},
        success: function(data) {
            var test = '';
            for (i=0;i<data.length;i++) {
                test += '<option value=' + data[i].id + '>' + data[i].code + '</option>';
            };
            $("#id").html(test);

            
        },
        error: function(data, jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }


    });

    //remplir(null);

    //$('#table_id').DataTable();

    /*$.ajax({
        url: 'controller/ClasseController.php',
        data: {op: ''},
        type: 'POST',
        success: function (data, textStatus, jqXHR) {
            //remplir(data);
            $('#table_id').DataTable( {
                data: data,
                columns: [
                    { title: "id_classe" },
                    { title: "code" },
                    { title: "id" }
                ]
            } );
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }
    });*/

    var table = $('#table_id').DataTable( {
            ajax: {
            url: 'controller/ClasseController.php',
            dataSrc: ''   
        },
        "columnDefs": [
            {
                "targets": [ 3 ],
                "visible": false,
                "searchable": false
            }
        ],
        columns: [
            { data: 'id_classe' },
            { data: 'code' },
            { data: 'fil' },
            { data: 'id' },
            {defaultContent : '<button type="button" class="btn btn-outline-secondary modifier">Modifier</button>'},
            {defaultContent : '<button type="button" class="btn btn-outline-danger supprimer">Supprimer</button>'}
        ]
        } );
    
    

    $('#btn').click(function () {
        var code = $("#code");
        var id = $("#id");
        if ($('#btn').text() == 'Ajouter') {
            console.log(id.val());
            $.ajax({
                url: 'controller/ClasseController.php',
                data: {op: 'add', code: code.val(),id: id.val()},
                type: 'POST',
                success: function (data, textStatus, jqXHR) {
                    //remplir(data);
                    table.ajax.reload();
                    code.val('');
                    id.val('');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            });
        }

    });

    $(document).on('click', '.supprimer', function () {
        var id = $(this).closest('tr').find('td').eq(0).text();
        console.log(id);
        $.ajax({
            url: 'controller/ClasseController.php',
            data: {op: 'delete', id_classe: id},
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                table.ajax.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
            }
        });
    });

    $(document).on('click', '.modifier', function () {
        var btn = $('#btn');

        var currentRow = $(this).closest("tr");

        var data = $('#table_id').DataTable().row(currentRow).data();
        var id_classe = data['id_classe'];
        var libelle = data['id'];
        var code = data['code'];

        console.log(libelle);
        btn.text('Modifier');
        $("#code").val(code);
        $("#id").val(libelle);
        $("#id_classe").val(id_classe);
        btn.click(function () {
            if ($('#btn').text() === 'Modifier') {
                $.ajax({
                    url: 'controller/ClasseController.php',
                    data: {op: 'update', id_classe: $("#id_classe").val(), code: $("#code").val(), id: $("#id").val()},
                    type: 'POST',
                    success: function (data, textStatus, jqXHR) {
                        table.ajax.reload();
                        $("#code").val('');
                        $("#id").val('');
                        btn.text('Ajouter');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                    }
                });
            }
        });
    });
    /*function remplir(data) {
        var contenu = $('#table-content');
        var ligne = "";
        for (i = 0; i < data.length; i++) {
            ligne += '<tr><th scope="row">' + data[i].id_classe + '</th>';
            ligne += '<td>' + data[i].code + '</td>';
            ligne += '<td>' + data[i].id + '</td>';
            ligne += '<td><button type="button" class="btn btn-outline-danger supprimer">Supprimer</button></td>';
            ligne += '<td><button type="button" class="btn btn-outline-secondary modifier">Modifier</button></td></tr>';
        }
        contenu.html(ligne);
    }
*/
});


