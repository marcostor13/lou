@extends('layouts.app')

@section('content')
<div id="crearTicket" class="container">
    <button onclick="window.location.href='/home'; " class="btn btn-primary mb-4"><i class="fas fa-arrow-left mr-2"></i>Regresar</button>
    <div class="row justify-content-center">
        
        <div class="col-md-12 col-sm-10 d-flex justify-content-center align-items-center flex-wrap">
            
            <form id="formTicket" class="col-12 col-md-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div title='Nuevo Cliente' onclick="window.location.href='/agregar-cliente'" class="pointer text-center">
                    <i class="agregarCliente fas fa-plus-circle  text-white mb-4 pt-1"></i>
                </div>               
              
                <div class="form-group relative">                    
                    <input data-id="" type="search" class="form-control" id="cliente" placeholder="Buscar Cliente" autocomplete="off">
                    <div id="resBuscarCliente" class="resultadoBusqueda"></div>
                </div>                    
                 
                
                <div class="form-group" >                    

                    <select class="form-control" id="servicios">
                        <option value="0">Servicio</option>                            
                    </select>
                    <div class="d-flex justify-content-between mt-2">
                        <div class="col-md-4 col-3 p-0">
                            <label class="text-white " for="cantidadservicios">Cantidad</label>
                            <input type="number" class="form-control" id="cantidadservicios" value="1">  
                        </div>
                        <div class="col-md-4 ml-md-2 col-3 p-0">
                            <label class="text-white " for="precioservicios">Precio</label>
                            <input type="text" class="form-control" id="precioservicios" >
                        </div>
                        <div class="col-md-4 ml-md-2 col-3 p-0">
                            <label class="text-white " for="descuentoservicios">Descuento</label>
                            <input type="text" class="form-control" id="descuentoservicios" >
                        </div>
                    </div>
                    <button id="agregarServicio" class="btn btn-primary mt-2">Agregar</button>
                </div>      
                
                <div id="divProductos"></div>

                <div id="error" class="text-white col-12 text-center mt-4 mb-4"></div>
                <div id="respuesta" class="text-success col-12 text-center mt-4 mb-4"></div>
                
                <button type="submit" class="btn btn-primary w-100">Crear Ticket</button>
                
            </form>
        </div>
    </div>
</div>
@endsection