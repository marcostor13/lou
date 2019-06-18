if (window.location.pathname.indexOf('administrar-usuarios') > -1) {

    $(function () {        
        obtenerUsuarios();  
    });

    let obtenerUsuarios = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#tablaUsuarios';
        $.post("/obtenerUsuarios", function () {

        })
        .done(function (e) {
            e = JSON.parse(e);
            e.forEach(element => {
                $(tagResult).append(`<tr data-id="${element.id}" data-name ="${element.name}">
                                    <th scope="row"><input id='id' class='form-control' type='text' value='${element.id}' disabled></th>
                                    <td><input id='name' class='form-control' type='text' value='${element.name}' disabled></td>
                                    <td><input id='email' class='form-control' type='text' value='${element.email}' disabled></td>
                                    <td><input id='password' class='form-control' type='password' value='${element.name}' disabled></td>
                                    <td>
                                        <select class="form-control" id="idRol" disabled>
                                            <option value="1">Administrador</option>
                                            <option value="2">Usuario</option>
                                            <option value="3">Cajero</option>
                                        </select>
                                    </td>
                                    <td class='pt-3'>
                                        <i title='Editar' class="pointer editarUsuario far fa-edit"></i>
                                        <i title='Guardar' class="pointer guardarUsuario far fa-check-circle ml-2 oculto"></i>
                                        <i data-id="${element.id}" title='Eliminar' class="pointer eliminarUsuario ml-2 fas fa-trash-alt"></i>
                                    </td>
                                </tr>
                                `);
                $('tr[data-id="' + element.id + '"] td select').val(element.idRol);
                
            });

            $('#adminUsuarios .editarUsuario').unbind('click').click(function(){
                $(this).parent().parent().children('td').children('input').prop('disabled', false);      
                $(this).parent().parent().children('td').children('select').prop('disabled', false);      
                $(this).parent().children('.guardarUsuario').show('fast'); 
            });

            $('#adminUsuarios .guardarUsuario').unbind('click').click(function () {
                guardarUsuario(this);
            });

            $('#adminUsuarios .eliminarUsuario').unbind('click').click(function () {
                $('#tituloModal').text('Información de Usuario');                               
                $('#contenidoModal').html('¿Está seguro de eliminar este usuario?'); 
                                
                $('#btnModal1').text('NO');
                
                $('#btnModal2').text('SI');

                let id = ($(this).attr('data-id')); 

                $('#btnModal2').unbind('click').click(function (elem) {
                    eliminarUsuario(id);
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

    let eliminarUsuario = function (id) {

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

        let tagResult = '#tablaUsuarios';
        $.post("/eliminarUsuario", datos, function () {

        })
        .done(function (e) {

            $('#tituloModal').text('Información de Usuario');
            $('#btnModal2').hide();
            $('#btnMOdal1').click(function(){
                window.location.reload();
            });

            if (e == 1) {               

                $('#contenidoModal').html('Usuario Elimnado');

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

    let guardarUsuario = function (elem) {
        
        let datos = {
            'id': $(elem).parent().parent().children('th').children('#id').val(),
            'name': $(elem).parent().parent().children('td').children('#name').val(),
            'email': $(elem).parent().parent().children('td').children('#email').val(),
            'password': $(elem).parent().parent().children('td').children('#password').val(),
            'idRol': $(elem).parent().parent().children('td').children('#idRol').val()
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#tablaUsuarios';
        $.post("/guardarUsuario", datos ,function () {

        })
        .done(function (e) {

            $('#tituloModal').text('Información de Usuario');
            $('#btnModal2').hide(); 
            
            if(e==1){

                $(elem).parent().parent().children('td').children('input').prop('disabled', true);
                $(elem).parent().parent().children('td').children('select').prop('disabled', true);
                $(elem).hide('fast');

                $('#contenidoModal').html('Usuario Guardado');                
                
            }else{

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


if (window.location.pathname.indexOf('agregar-usuario') > -1) {

    $(function () {

        $('#formCrearUsuario').submit(function () {
            crearUsuario();
            return false;
        });

    });


    let crearUsuario = function () {

        let form = $('#formCrearUsuario');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#respuestaCrearUsuario';
        $.post("/crearUsuario", form.serialize(), function () {

        })
            .done(function (e) {

                $('#tituloModal').text('Información de Usuario');
                $('#btnModal2').hide();

                if (e == 1) {

                    $('#contenidoModal').html('Usuario Creado');

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

if (window.location.pathname.indexOf('cupon') > -1) {

    $(function () {
        obtenerCupones();
        obtenerUsuariosSelect();

        $('#formCrearCupon').submit(function () {
            crearCupon();
            return false;
        });

    });

    let obtenerCupones = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#tablaCupones';
        $.post("/obtenerCupones", function () {

        })
            .done(function (e) {
                e = JSON.parse(e);
                e.forEach(element => {
                    $(tagResult).append(`<tr data-id="${element.id}"}">
                                    <th scope="row"><input id='id' class='form-control' type='text' value='${element.id}' disabled></th>
                                    <td><input id='fecha' class='form-control' type='text' value='${element.created_at}' disabled></td>
                                    <td><input id='usuario' class='form-control' type='text' value='${element.usuario}' disabled></td>
                                    <td><input id='descripcion' class='form-control' type='text' value='${element.descripcion}' disabled></td>
                                    <td><input id='valor' class='form-control' type='text' value='${element.valor}' disabled></td>
                                    
                                </tr>
                                `);
                    

                });
            })
            .fail(function (e) {
                $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });

    }


    let obtenerUsuariosSelect = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#selectUsuarios';
        $.post("/obtenerUsuariosSelect", function () {

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


    let crearCupon = function () {

        let form = $('#formCrearCupon');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#respuestaCrearCupon';
        $.post("/crearCupon", form.serialize(), function () {

        })
            .done(function (e) {

                $('#tituloModal').text('Información de Cupon');
                $('#btnModal2').hide();

                if (e == 1) {

                    $('#contenidoModal').html('Cupon Creado');
                    $('#formCrearCupon input').val('');
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



if (window.location.pathname.indexOf('pagos') > -1) {

    $(function () {

        obtenerUsuariosSelect();


        $('#selectUsuarios').change(function () {
            obtenerPagos();
            return false;
        });
        $('#fechaInicio').change(function () {
            obtenerPagos();
            return false;
        });
        $('#fechaFin').change(function () {
            obtenerPagos();
            return false;
        });

    });

    let obtenerUsuariosSelect = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#selectUsuarios';
        $.post("/obtenerUsuariosSelect", function () {

        })
            .done(function (e) {
                e = JSON.parse(e);
                e.forEach(element => {
                    $(tagResult).append(`<option value="${element.id}">${element.name}</option>`);
                });
                obtenerPagos();
            })
            .fail(function (e) {
                $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });

    }


    let obtenerPagos = function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let datos = {
            'usuario': $('#selectUsuarios').val(),
            'fechaInicio': $('#fechaInicio').val(),
            'fechaFin': $('#fechaFin').val()
        }

        let tagResult = '#tablaPagos';

        $(tagResult).text('...Procesando');

        $.post("/obtenerPagos", datos, function () {

        })
            .done(function (e) {

                e = JSON.parse(e);

                if (e.estado != 200) {
                    $(tagResult).text(e.datos);
                } else {

                    $(tagResult).html('');
                    let cont = 1; 
                    let element = e.datos;

                    if (element.cupones == null){
                        element.cupones = 0;
                    }

                        $(tagResult).append(`<tr>                                    
                                    <td>${cont}</td>
                                    <td>${element.usuario}</td>
                                    <td>${element.subTotal}</td>
                                    <td>${element.cupones}</td>
                                    <td>${element.total}</td>
                                </tr>
                                `);

                                cont++;
                    
                    

                }



            })
            .fail(function (e) {
                $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
            })
            .always(function () {
                // $(tagResult).html(''); 
            });
    }

}