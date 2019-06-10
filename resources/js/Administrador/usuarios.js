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
                                        <i title='Eliminar' class="pointer eliminarUsuario ml-2 fas fa-trash-alt"></i>
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
                $('#btnModal2').unbind('click').click(function () {
                    eliminarUsuario();
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