@extends('layouts.app')

@section('content')
<div id="crearTicket" class="container">
    <button onclick="window.location.href='/home'; " class="btn btn-primary mb-4"><i class="fas fa-arrow-left mr-2"></i>Regresar</button>
    <div class="row justify-content-center">
        
        <div class="col-md-12 col-sm-10 d-flex justify-content-center align-items-center flex-wrap">
            
            <form id="formTicket" class="col-12 col-md-8">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="seccionForm">                
                    <div class="form-group relative">                    
                        <input data-id="" type="search" class="form-control" id="cliente" placeholder="Buscar Cliente" autocomplete="off">
                        <div id="resBuscarCliente" class="resultadoBusqueda"></div>
                    </div>                    
                </div>                    
                
                <div class="form-group row justify-content-around" >                    
                    <div class="col-9" >
                        <select class="form-control" id="servicios">
                            <option value="0">Servicio</option>                            
                        </select>
                        <div class="mt-2 d-flex">
                            <input type="number" class="form-control" id="cantidadservicios" value="1">  
                            <input type="text" class="form-control ml-2" id="precioservicios" placeholder="Precio Sev.">
                        </div>
                    </div>
                    <button id="agregarServicio" class="btn btn-primary">Agregar</button>
                </div>               
                
                <div id="divProductos" class="form-group row justify-content-around ">                    
                    <div class="col-9" >
                        <select class="form-control" id="productos">
                            <option value="0">Producto</option>                            
                        </select> 
                        <div class="mt-2 d-flex">
                            <input type="number" class="form-control" id="cantidadproductos" value="1">                        
                            <input type="text" class="form-control ml-2" id="precioproductos" placeholder="Precio Prod.">                        
                        </div>                   
                    </div>                    
                    <button id="agregarProducto" class="btn btn-primary">Agregar</button>
                </div>    

                <div id="error" class="text-danger col-12 text-center mt-4 mb-4"></div>
                <div id="respuesta" class="text-success col-12 text-center mt-4 mb-4"></div>
                
                <button type="submit" class="btn btn-primary w-100">Crear Ticket</button>
                
            </form>
        </div>
    </div>
</div>
@endsection