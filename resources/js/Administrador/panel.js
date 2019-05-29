if (window.location.pathname.indexOf('panel') > -1) {

    $(function () {
        obtenerUsuarios();
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

    $.post("/obtenerDatosPanel", function () {
       
    })
    .done(function (e) {
        console.log(e);
        e = JSON.parse(e);
        e.forEach(element => {
            
        });
    })
    .fail(function (e) {
        $('#panel').append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
    })
    .always(function () {
        // $(tagResult).html(''); 
    });

}