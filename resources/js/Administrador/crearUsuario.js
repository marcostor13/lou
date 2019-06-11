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