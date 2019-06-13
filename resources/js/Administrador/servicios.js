if (window.location.pathname.indexOf('administrar-servicios') > -1) {

    $(function () {
        obtenerServicios();
    });

    let obtenerServicios = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#tablaServicios';
        $.post("/obtenerServicios", function () {

        })
            .done(function (e) {
                e = JSON.parse(e);
                e.forEach(element => {
                    $(tagResult).append(`<tr data-id="${element.id}" data-name ="${element.name}">
                                    <th scope="row"><input id='id' class='form-control' type='text' value='${element.id}' disabled></th>
                                    <td><input id='nombre' class='form-control' type='text' value='${element.nombre}' disabled></td>
                                    <td><input id='descripcion' class='form-control' type='text' value='${element.descripcion}' disabled></td>
                                    <td><input id='precio' class='form-control' type='text' value='${element.precio}' disabled></td>
                                    <td><input id='descuento' class='form-control' type='text' value='${element.descuento}' disabled></td>                                    
                                    <td class='pt-3'>
                                        <i title='Editar' class="pointer editarUsuario far fa-edit"></i>
                                        <i title='Guardar' class="pointer guardarServicio far fa-check-circle ml-2 oculto"></i>
                                        <i data-id="${element.id}" title='Eliminar' class="pointer eliminarServicio ml-2 fas fa-trash-alt"></i>
                                    </td>
                                </tr>
                                `);                   

                });

                $('#adminServicios .editarUsuario').unbind('click').click(function () {
                    $(this).parent().parent().children('td').children('input').prop('disabled', false);
                    $(this).parent().parent().children('td').children('select').prop('disabled', false);
                    $(this).parent().children('.guardarServicio').show('fast');
                });

                $('#adminServicios .guardarServicio').unbind('click').click(function () {
                    guardarServicio(this);
                });

                $('#adminServicios .eliminarServicio').unbind('click').click(function () {
                    $('#tituloModal').text('Información de Servicio');
                    $('#contenidoModal').html('¿Está seguro de eliminar este servicio?');

                    $('#btnModal1').text('NO');

                    $('#btnModal2').text('SI');

                    let id = ($(this).attr('data-id'));

                    $('#btnModal2').unbind('click').click(function () {
                        eliminarServicio(id);
                    });
                    $('#myModal').modal('show');
                });



            })
            .fail(function (e) {
                $(tagResult).append(`<span >Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });

    }

    let eliminarServicio = function (id) {
       

        let datos = {
            'id': id
        }

        $('#btnModal1').text('Cerrar');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#tablaServicios';
        $.post("/eliminarServicio", datos, function () {

        })
            .done(function (e) {

                $('#tituloModal').text('Información de Servicio');
                $('#btnModal2').hide();
                $('#btnMOdal1').click(function () {
                    window.location.reload();
                });

                if (e == 1) {

                    $('#contenidoModal').html('Servicio Elimnado');
                    obtenerServicios();

                } else {

                    $('#contenidoModal').html(e);

                }

                $('#myModal').modal('show');
            })
            .fail(function (e) {
                $(tagResult).append(`<span >Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });

    }

    let guardarServicio = function (elem) {

        let datos = {
            'id': $(elem).parent().parent().children('th').children('#id').val(),
            'nombre': $(elem).parent().parent().children('td').children('#nombre').val(),
            'descripcion': $(elem).parent().parent().children('td').children('#descripcion').val(),
            'precio': $(elem).parent().parent().children('td').children('#precio').val(),
            'descuento': $(elem).parent().parent().children('td').children('#descuento').val()
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#tablaServicios';
        $.post("/guardarServicio", datos, function () {

        })
            .done(function (e) {

                $('#tituloModal').text('Información de Servicio');
                $('#btnModal2').hide();

                if (e == 1) {

                    $(elem).parent().parent().children('td').children('input').prop('disabled', true);
                    $(elem).parent().parent().children('td').children('select').prop('disabled', true);
                    $(elem).hide('fast');

                    $('#contenidoModal').html('Servicio Guardado');

                } else {

                    $('#contenidoModal').html(e);

                }

                $('#myModal').modal('show');
            })
            .fail(function (e) {
                $(tagResult).append(`<span >Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });

    }
}


if (window.location.pathname.indexOf('servicio') > -1) {

    $(function () {
        $('#formCrearServicio').submit(function () {
            crearServicio();
            return false;
        });
    });

    let crearServicio = function () {

        let form = $('#formCrearServicio');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#respuestaCrearServicio';
        $.post("/agregarServicio", form.serialize(), function () {

        })
            .done(function (e) {

                $('#tituloModal').text('Información de Servicio');
                $('#btnModal2').hide();

                if (e == 1) {

                    $('#contenidoModal').html('Servicio Creado');

                } else {

                    $('#contenidoModal').html(e);

                }

                $('#myModal').modal('show');

                $('#formCrearServicio input').val('');
            })
            .fail(function (e) {
                $(tagResult).append(`<span >Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });

    }

}