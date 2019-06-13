if (window.location.pathname.indexOf('panel') > -1) {

    $(function () {
        obtenerUsuarios();
        obtenerDatosPanel();

        $('#usuarios').change(function () {
            obtenerDatosPanel()
        });

        $('#fInicio').change(function () {
            obtenerDatosPanel()
        });

        $('#fFinal').change(function () {
            obtenerDatosPanel()
        });
     

    });

}

let detectarCambios = function(id,func){
    $(id).change(function () {
        func;
    });
}

let obtenerUsuarios = function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let tagResult = '#usuarios';
    $.post("/obtenerUsuarios", function () {
        
    })
    .done(function (e) {
        e = JSON.parse(e);
        e.forEach(element => {
            $(tagResult).append(`<option value="${element.id}">${element.name}</option>`);
        });
    })
    .fail(function (e) {
        $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
    })
    .always(function () {
        // $(tagResult).html(''); 
    });

}


let obtenerDatosPanel = function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let datos = {
        'idUsuario': $('#usuarios').val(),
        'fInicio': $('#fInicio').val(),
        'fFinal': $('#fFinal').val()
    }


    $.post("/obtenerDatosPanel", datos, function () {
       
    })
    .done(function (e) {
        
        e = JSON.parse(e);
        
        $('#cantTickets').text(e.cantTickets);
        $('#totalFacturado').text('S/ ' + e.totalFacturado);
        $('#gananciaNeta').text('S/ ' + e.gananciaNeta);
        $('#gananciaUsuario').text('S/ ' + e.gananciaUsuario); 
        $('#totalDescuentos').text('S/ ' + e.totalDescuentos); 
        
        console.log(e.servCantidad);

        serviciosCantidad(e.servCantidad);
        usuarioTicket(e.usuarioTicket);
        
        // e.forEach(element => {
            
        // });
    })
    .fail(function (e) {
        $('#panel').append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
    })
    .always(function () {
        // $(tagResult).html(''); 
    });

}


let serviciosCantidad = function(servCantidad){

    let cat = []; 
    let data = []; 

    for (var key in servCantidad) {
        cat.push(key); 
        data.push(parseInt(servCantidad[key]));
        console.log("key " + key + " has value " + servCantidad[key]);
    }

    cuadros('cuadro1', 'barras', 'Servicios x Cantidad', '', 'Servicios', 'Cantidad', cat, data); 

}

let usuarioTicket = function (usuarioTicket) {

    let cat = [];
    let data = [];

    for (var key in usuarioTicket) {
        cat.push(key);
        data.push(parseInt(usuarioTicket[key]));
        console.log("key " + key + " has value " + usuarioTicket[key]);
    }

    cuadros('cuadro2', 'barras', 'Usuarios x Tickets', '', 'Usuarios', 'Cantidad Tickets', cat, data);

}


let cuadros = function (cont, tipo, titulo, subtitulo, titY, titX, cat, data){

    switch (tipo) {
        case 'barras':
            Highcharts.chart(cont, {
                chart: {
                    type: 'column'
                },
                title: {
                    text: titulo
                },
                subtitle: {
                    text: subtitulo
                },
                xAxis: {
                    categories : cat,
                    // categories: [
                    //     'Jan',
                    //     'Feb',
                    //     'Mar',
                    //     'Apr',
                    //     'May',
                    //     'Jun',
                    //     'Jul',
                    //     'Aug',
                    //     'Sep',
                    //     'Oct',
                    //     'Nov',
                    //     'Dec'
                    // ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: titY
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },

                series: [{
                    name: titX,
                    data: data

                }]

                // series: [{
                //     name: 'Tokyo',
                //     data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4]

                // }, {
                //     name: 'New York',
                //     data: [83.6, 78.8, 98.5, 93.4, 106.0, 84.5, 105.0, 104.3, 91.2, 83.5, 106.6, 92.3]

                // }, {
                //     name: 'London',
                //     data: [48.9, 38.8, 39.3, 41.4, 47.0, 48.3, 59.0, 59.6, 52.4, 65.2, 59.3, 51.2]

                // }, {
                //     name: 'Berlin',
                //     data: [42.4, 33.2, 34.5, 39.7, 52.6, 75.5, 57.4, 60.4, 47.6, 39.1, 46.8, 51.1]

                // }]
            });
            break;
    
        default:
            break;
    }

    

}