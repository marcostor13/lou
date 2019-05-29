if (window.location.pathname.indexOf('ticket')>-1 ){

    $(function () {        
        
        if (window.location.pathname.indexOf('crear-ticket') > -1) {

            $('#cliente')
            .keyup(function(){
                $('#error').text(''); 
                if($(this).val() == ''){
                    $('#resBuscarCliente').html('');
                }else{
                    imprimirClientes(); 
                }
            });

            obtenerServiciosProductos('servicios');
            obtenerServiciosProductos('productos');
            
            $('#agregarProducto').click(function(){
                $('#error').text(''); 
                agregarServicioProducto('productos');
                return false;
            });

            $('#agregarServicio').click(function () {
                $('#error').text(''); 
                agregarServicioProducto('servicios');
                return false;
            });

            $('#formTicket').submit(function(){
                $('#error').text(''); 
                crearTicket();
                return false;
            });

        }

        if (window.location.pathname.indexOf('tickets-usuario') > -1) {
            obtenerTickets();
            $('#fechaInicio').change(function () {
                obtenerTickets();
            });
            $('#fechaFin').change(function () {
                obtenerTickets();
            }); 
        }

        if (window.location.pathname.indexOf('tickets-admin') > -1) {
            obtenerTicketsAdmin();
            $('#fechaInicio').change(function () {
                obtenerTicketsAdmin();
            });
            $('#fechaFin').change(function () {
                obtenerTicketsAdmin();
            });
        }

        

    });

    
    
    let imprimirClientes = function() {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let datos = {
            'busqueda' : $('#cliente').val()
        }

        let tagResult = '#resBuscarCliente'; 
        $.post("/obtenerClientes", datos ,function () {
                $(tagResult).html(''); 
            })            
            .done(function (e) {
               e = JSON.parse(e);
               e.forEach(element => {
                   $(tagResult).append(`<li data-id="${element.id}">${element.nombre}</li>`);
               }); 
               
               $(tagResult+' li').click(function(){
                   selecionar(tagResult, '#cliente', $(this).text(), $(this).attr('data-id')); 
               }); 
               
            })
            .fail(function (e) {
                $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`); 
            })
            .always(function () {
                // $(tagResult).html(''); 
            });
    }    

    let selecionar = function (idResultado, idInput, texto, id) {

        $(idInput).val(texto); 
        $(idInput).attr('data-id', id);
        $(idResultado).html(''); 

    }

    let obtenerServiciosProductos = function (tipo) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var datos = {
            'tabla': tipo
        }

        let tagResult = '#'+tipo;
        
        $.post("/obtenerDatosTabla", datos, function(){
            // console.log('asdf');
        })
        .done(function (e) {
            e = JSON.parse(e);
            e.forEach(element => {
                $(tagResult).append(`<option data-precio="${element.precio}" value="${element.id}">${element.nombre} - S/.${element.precio}</option>`);
            });
            $(tagResult).change(function () {
                selecionarPrecio($(this), tipo);
            });

        })
        .fail(function (e) {
            $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
        })
        .always(function () {
            // $(tagResult).html(''); 
        });
    }

    let selecionarPrecio = function (element, tipo) {
        let precio = $('#' + tipo + ' option:selected').attr('data-precio');
        $('#precio' + tipo).val(precio);       
    }

    let agregarServicioProducto = function(tipo){

        let precio = $('#precio'+tipo).val();
        //Id del producto o servicio
        let idPS = $('#' + tipo).val();
        let nombre = $('#'+tipo+' option:selected').text().split('-')[0].trim();
        let cantidad = $('#cantidad'+tipo).val(); 

        if(precio == '' || idPS == '0' || cantidad == ''){
            return false; 
        }

        $('#divProductos').after(`
            <div data-tipo="${tipo}" data-id="${idPS}"  data-precio="${precio}" data-cantidad="${cantidad}" data-nombre="${nombre}" class="tickets form-group d-flex justify-content-between align-items-center pt-2 pb-2 pl-1 pr-1 bg-warning rounded">
                <span id="nombreCliente" class="col-11">${cantidad} ${nombre} - S/ ${precio}</span>                    
                <i onclick="$(this).parent().remove();" class="fas fa-times pointer col-1"></i>
            </div>`
        ); 

        $('#precio' + tipo).val('');
        $('#' + tipo).val('0');
        $('#cantidad' + tipo).val('1');

    }

    let crearTicket = function(){        

        let nombreCliente = $('#cliente').val();  
        let idCliente = $('#cliente').attr('data-id');  

        if(nombreCliente == ''){
            $('#error').text('Debe ingresar un cliente'); 
            return false; 
        }
        
        let tickets = $('.tickets');
        
        if(tickets.length > 0){
            let items = []
            for (let i = 0; i < tickets.length; i++) {
                const element = tickets[i];
                items.push({
                    'tipo': $(element).attr('data-tipo'),
                    'id': $(element).attr('data-id'),
                    'precio': $(element).attr('data-precio'),
                    'cantidad': $(element).attr('data-cantidad'),
                    'nombre': $(element).attr('data-nombre')                    
                }); 
            }

            let datos = {
                'userID': $('#userID').val(),
                'cliente': nombreCliente,
                'idCliente': idCliente,
                'items': JSON.stringify(items)
            }

            insertarTicket(datos); 

        }else{
            $('#error').text('Debe ingresar al menos un servicio o producto'); 
        }

    }

    let insertarTicket = function(datos){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let tagResult = '#respuesta';

        $('.tickets').remove();
        $('#cliente').val('');
        $(tagResult).text('...Procesando'); 

        $.post("/crearTicket", datos, function () {            
        })
        .done(function (e) {                        
            $(tagResult).text(e);             
        })
        .fail(function (e) {
            $(tagResult).append(`<span class="text-danger">Error: ${(e.responseText)}</span>`);
        })
        .always(function () {
            // $(tagResult).html(''); 
        });
    }


    let obtenerTickets = function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let datos = {
            'userID' : $('#userID').val(),
            'fechaInicio' : $('#fechaInicio').val(),
            'fechaFin' : $('#fechaFin').val()
        }

        let tagResult = '#tablaTickets';

        $(tagResult).text('...Procesando'); 

        $.post("/obtenerTickets", datos, function () {

        })
        .done(function (e) {       
           
            e = JSON.parse(e); 
            
            if (e.estado != 200){
                $(tagResult).text(e.datos);
            }else{
                // let a = 1; 
                $(tagResult).html(''); 
                e.datos.forEach(element => {
                    $(tagResult).append(`<tr class="pointer" data-items="${element.item_id}" data-ticket_id ="${element.ticket_id}">
                                    <th scope="row">${element.ticket_id}</th>
                                    <td>${element.fecha}</td>
                                    <td>${element.nombre}</td>
                                    <td>${element.precio}</td>
                                </tr>
                                `); 
                    // a = a+1;
                });

                $('#tablaTickets tr').click(function(){
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


    let obtenerDetalleTicket = function (items, ticket_id) {        
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
       

        let datos = {
            'items' : items,
            'ticket_id' : ticket_id
        }

        let tagResult = '#detalleTicket';

        $(tagResult).text('...Procesando'); 

        $.post("/obtenerDetalleTicket", datos, function () {

        })
        .done(function (e) {             
                       
            e = JSON.parse(e); 

         
            if (e.estado != 200){
                $(tagResult).text(e.datos);
            }else{               
                
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

                if($('#roleUser').val() === 'admin'){
                    $('#adicional').text('Editar').show().click(function(){
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


    let desahibilitarEdicion = function(){
        let datos = $('#contenidoModal td input');

        for (let i = 0; i < datos.length; i++) {
            const element = datos[i];
            const text = element.value;
            $(element).parent().html(`${text}`);
        }
    }


    let editarTicket = function(ticket_id){

        console.log(); 

        let datos = $('#contenidoModal td');

        for (let i = 0; i < datos.length; i++) {
            const element = datos[i];
            const text = element.innerText;
            $(element).html(`<input class="form-control" type="text" value="${text}">`);    
        }

        $('#btnModal2').text('Guardar').show().click(function(){
            guardarTicket();
        });
        
        $('#adicional').prop('disabled', true);

        // $('#myModal').modal('show');
        // $('#btnModal2').hide(); 
    }

    let guardarTicket = function(){
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

    


}

