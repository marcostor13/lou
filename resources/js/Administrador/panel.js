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


        obtenerTicketsAdmin();
        $('#fechaInicio').change(function () {
            obtenerTicketsAdmin();
        });
        $('#fechaFin').change(function () {
            obtenerTicketsAdmin();
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
        $('#totalPrecioProductos').text('S/ ' + e.totalPrecioProductos); 
        
        
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




/////**************** ADMIN  *****************////


let obtenerTicketsAdmin = function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let datos = {
        'userID': $('#userID').val(),
        'fechaInicio': $('#fechaInicio').val(),
        'fechaFin': $('#fechaFin').val()
    }

    let tagResult = '#tablaTickets';

    $(tagResult).text('...Procesando');

    $.post("/obtenerTicketsAdmin", datos, function () {

    })
        .done(function (e) {

            e = JSON.parse(e);

            if (e.estado != 200) {
                $(tagResult).text(e.datos);
            } else {
                let a = 1;
                $(tagResult).html('');
                e.datos.forEach(element => {
                    $(tagResult).append(`<tr class="pointer" data-items="${element.item_id}" data-ticket_id ="${element.ticket_id}">
                                    <th scope="row">${a}</th>
                                    <td>${element.fecha}</td>
                                    <td>${element.user_name}</td>
                                    <td>${element.nombre}</td>
                                    <td>${element.precio}</td>
                                </tr>
                                `);
                    a = a + 1;
                });

                $('#tablaTickets tr').click(function () {
                    let items = $(this).attr('data-items');
                    let ticket_id = $(this).attr('data-ticket_id');

                    obtenerDetalleTicket(items, ticket_id);

                });

            }



        })
        .fail(function (e) {
            $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
        })
        .always(function () {
            // $(tagResult).html(''); 
        });
}


let desahibilitarEdicion = function () {
    let datos = $('#contenidoModal td input');

    for (let i = 0; i < datos.length; i++) {
        const element = datos[i];
        const text = element.value;
        $(element).parent().html(`${text}`);
    }
}


let editarTicket = function (ticket_id) {

    console.log();

    let datos = $('#contenidoModal td');

    for (let i = 0; i < datos.length; i++) {
        const element = datos[i];
        const text = element.innerText;
        $(element).html(`<input class="form-control" type="text" value="${text}">`);
    }

    $('#btnModal2').text('Guardar').show().click(function () {
        guardarTicket();
    });

    $('#adicional').prop('disabled', true);

    // $('#myModal').modal('show');
    // $('#btnModal2').hide(); 
}

let guardarTicket = function () {
    console.log($('#contenidoModal tr'));

    let elements = $('#contenidoModal tr');

    let datos = [];

    for (let i = 1; i < elements.length; i++) {
        const element = elements[i];

        let child = element.children;

        let valores = {};

        valores['id_item'] = $(element).attr('data-id');
        valores['tipo'] = $(element).attr('data-tipo');

        for (let x = 1; x < child.length; x++) {
            const hijo = child[x];

            switch (x) {
                case 1:
                    valores['cantidad'] = $(hijo).children('input').val();
                    break;
                case 2:
                    valores['nombre'] = $(hijo).children('input').val();
                    break;
                case 3:
                    valores['precio'] = $(hijo).children('input').val();
                    break;
                default:
                    break;
            }

        }

        datos.push(valores);

    }

    $('#adicional').prop('disabled', false);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    let dat = {
        'userID': $('#userID').val(),
        'datos': JSON.stringify(datos)
    }

    let tagResult = '#respuestaModal';

    $(tagResult).text('...Procesando');

    $.post("/guardarTickets", dat, function () {

    })
        .done(function (e) {
            e = JSON.parse(e);
            $(tagResult).text(e.datos);
            desahibilitarEdicion();
        })
        .fail(function (e) {
            $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
        })
        .always(function () {
            // $(tagResult).html(''); 
        });


}


let obtenerDetalleTicket = function (items, ticket_id) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    let datos = {
        'items': items,
        'ticket_id': ticket_id
    }

    let tagResult = '#detalleTicket';

    $(tagResult).text('...Procesando');

    $.post("/obtenerDetalleTicket", datos, function () {

    })
        .done(function (e) {

            e = JSON.parse(e);


            if (e.estado != 200) {
                $(tagResult).text(e.datos);
            } else {

                $('#tituloModal').text('Detalle de Ticket');
                $('#contenidoModal').html(`
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Precio</th>
                        </tr>
                        </thead>
                        <tbody id="contenidoTablaTicket">                                                   
                        </tbody>
                    </table>
                `);

                a = 1;

                e.datos.forEach(element => {
                    $('#contenidoTablaTicket').append(`                   
                        <tr data-id="${element.id_item}" data-tipo="${element.tipo}">
                            <th scope="row">${a}</th>
                            <td>${element.cantidad}</td>
                            <td>${element.nombre}</td>
                            <td>${element.precio}</td>
                        </tr> 
                    `);

                    a++;
                });

                $('#myModal').modal('show');
                $('#respuestaModal').html('');
                $('#btnModal2').hide();

                $('#adicional').prop('disabled', false);

                if ($('#roleUser').val() === 'admin') {
                    $('#adicional').text('Editar').show().click(function () {
                        editarTicket(ticket_id);
                    });

                }

            }

        })
        .fail(function (e) {
            $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
        })
        .always(function () {
            // $(tagResult).html(''); 
        });

}