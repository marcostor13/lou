@extends('layouts.app')

@section('content')
<div id="crearCupones" class="container">
    <button onclick="window.location.href='/cupones'; " class="btn btn-primary mb-4"><i class="fas fa-arrow-left mr-2"></i>Regresar</button>
    <div class="row justify-content-center">              
            <form id="formCrearCupon" class="col-12 col-sm-6">

                <div class="form-group">                  
                  <select id="selectUsuarios" name="usuario" class="form-control" required></select>                  
                </div>
                <div class="form-group">                  
                  <input type="text" name="descripcion" class="form-control" placeholder="Descripción" required>                
                </div>
                <div class="form-group">                  
                  <input type="text" name="valor" class="form-control" placeholder="Valor" required>                  
                </div>                
                <div class="form-group">
                    <button type="submit" class="btn1 form-control">Crear Cupon</button>
                </div>
                <div class="respuestaCreaCupon"></div>
                
            </form>        
    </div>
</div>


@endsection