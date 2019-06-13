if (window.location.pathname.indexOf('administrar-clientes') > -1) {

    $(function () {
        obtenerClientes();
    });

    let obtenerClientes = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#tablaClientes';
        $.post("/obtenerClientes", function () {

        })
            .done(function (e) {
                e = JSON.parse(e);
                e.forEach(element => {
                    $(tagResult).append(`<tr data-id="${element.id}" data-name ="${element.name}">
                                    <th scope="row"><input id='id' class='form-control' type='text' value='${element.id}' disabled></th>
                                    <td><input id='nombre' class='form-control' type='text' value='${element.nombre}' disabled></td>
                                    <td><input id='correo' class='form-control' type='text' value='${element.correo}' disabled></td>
                                    <td><input id='telefono' class='form-control' type='text' value='${element.telefono}' disabled></td>
                                    
                                    <td class='pt-3'>
                                        <i title='Editar' class="pointer editarCliente far fa-edit"></i>
                                        <i title='Guardar' class="pointer guardarCliente far fa-check-circle ml-2 oculto"></i>
                                        <i data-id="${element.id}" title='Eliminar' class="pointer eliminarCliente ml-2 fas fa-trash-alt"></i>
                                    </td>
                                </tr>
                                `);
                    $('tr[data-id="' + element.id + '"] td select').val(element.idRol);

                });

                $('#adminClientes .editarCliente').unbind('click').click(function () {
                    $(this).parent().parent().children('td').children('input').prop('disabled', false);
                    $(this).parent().parent().children('td').children('select').prop('disabled', false);
                    $(this).parent().children('.guardarCliente').show('fast');
                });

                $('#adminClientes .guardarCliente').unbind('click').click(function () {
                    guardarCliente(this);
                });

                $('#adminClientes .eliminarCliente').unbind('click').click(function () {
                    $('#tituloModal').text('Información de Cliente');
                    $('#contenidoModal').html('¿Está seguro de eliminar este Cliente?');

                    $('#btnModal1').text('NO');

                    $('#btnModal2').text('SI');

                    let id = ($(this).attr('data-id'));

                    $('#btnModal2').unbind('click').click(function (elem) {
                        eliminarCliente(id);
                    });
                    $('#myModal').modal('show');
                });



            })
            .fail(function (e) {
                $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });

    }

    let eliminarCliente = function (id) {

        console.log(id);

        let datos = {
            'id': id
        }

        $('#btnModal1').text('Cerrar');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#tablaClientes';
        $.post("/eliminarCliente", datos, function () {

        })
            .done(function (e) {

                $('#tituloModal').text('Información de Cliente');
                $('#btnModal2').hide();
                $('#btnMOdal1').click(function () {
                    window.location.reload();
                });

                if (e == 1) {

                    $('#contenidoModal').html('Cliente Elimnado');

                } else {

                    $('#contenidoModal').html(e);

                }

                $('#myModal').modal('show');
            })
            .fail(function (e) {
                $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });

    }

    let guardarCliente = function (elem) {

        let datos = {
            'id': $(elem).parent().parent().children('th').children('#id').val(),
            'nombre': $(elem).parent().parent().children('td').children('#nombre').val(),
            'correo': $(elem).parent().parent().children('td').children('#correo').val(),
            'telefono': $(elem).parent().parent().children('td').children('#telefono').val(),
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#tablaClientes';
        $.post("/guardarCliente", datos, function () {

        })
            .done(function (e) {

                $('#tituloModal').text('Información de Cliente');
                $('#btnModal2').hide();

                if (e == 1) {

                    $(elem).parent().parent().children('td').children('input').prop('disabled', true);
                    $(elem).parent().parent().children('td').children('select').prop('disabled', true);
                    $(elem).hide('fast');

                    $('#contenidoModal').html('Cliente Guardado');

                } else {

                    $('#contenidoModal').html(e);

                }

                $('#myModal').modal('show');
            })
            .fail(function (e) {
                $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });

    }
}


if (window.location.pathname.indexOf('agregar-cliente') > -1) {

    $(function () {

        $('#formAgregarCliente').submit(function () {
            agregarCliente();
            return false;
        });

    });


    let agregarCliente = function () {

        let form = $('#formAgregarCliente');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#respuestaAgregarCliente';
        $.post("/agregarCliente", form.serialize(), function () {

        })
            .done(function (e) {

                $('#tituloModal').text('Información de Cliente');
                $('#btnModal2').hide();

                if (e == 1) {

                    $('#contenidoModal').html('Cliente Agregado');

                } else {

                    $('#contenidoModal').html(e);

                }

                $('#myModal').modal('show');
            })
            .fail(function (e) {
                $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });

    }

}