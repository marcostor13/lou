@extends('layouts.app')

@section('content')
<div id="crearServicios" class="container">
    <button onclick="window.location.href='/administrar-servicios'; " class="btn btn-primary mb-4"><i class="fas fa-arrow-left mr-2"></i>Regresar</button>
    <div class="row justify-content-center">              
            <form id="formCrearServicio" class="col-12 col-sm-6">

                <div class="form-group">                  
                  <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>                  
                </div>
                <div class="form-group">                  
                  <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>                  
                </div>
                <div class="form-group">                  
                  <input type="text" name="precio" class="form-control" placeholder="Precio S/" required>                  
                </div>
                <div class="form-group">                  
                  <input type="text" name="descuento" class="form-control" placeholder="Descuento" required>                  
                </div> 
                <div class="form-group">
                    <button type="submit" class="btn1 form-control">Crear Servicio</button>
                </div>
                <div class="respuestaCrearServicio"></div>
                
            </form>        
    </div>
</div>


@endsection