$(document).ready(function () {
    function getCountFrom(url, i) {
        $.ajax({
            url: url,
            data: {op: ''},
            type: 'POST',
            success: function (data, textStatus, jqXHR) {
                $('h2[class="number"]').eq(i).text(data.length);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('h2[class="number"]').eq(i).text('...');
            }
        });
    }
    getCountFrom('controller/FiliereController.php', 0);
    getCountFrom('controller/ClasseController.php', 1);
    //var ctx = document.getElementById('myChart').getContext('2d');

    $.ajax({
        url: 'controller/countController1.php',
        data: {op: ''},
        type: 'POST',
        success: function(data, textStatus, jqXHR) {
            label = [];
            datas = [];
            for (i = 0; i < data.length; i++) {
                label.push('Classe de:'+data[i].filiere);
                datas.push(data[i].nbr);
            }
            console.log(label);
            new Chart(document.getElementById("myChart"), {
                type: 'bar',
                data: {
                    labels:label, 
                            datasets: [
                                {
                                    label: "Nombre des Classes",
                                    backgroundColor: ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"],
                                    data:datas  
                                }
                            ]
                },
                options: {
                    legend: {display: false},
                    title: {
                        display: true,
                        text: 'nombre des Classes par Filiere'
                    },
                    responsive: false,
                }
            });

        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus);
        }
    });
    
});

