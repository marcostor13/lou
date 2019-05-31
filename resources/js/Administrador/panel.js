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





