@extends('layouts.app')

@section('content')
<div class="container">
    <button onclick="history.back();" class="btn btn-primary mb-4"><i class="fas fa-arrow-left mr-2"></i>Regresar</button>
    <div id="agregarCliente" class="row justify-content-center">
        
        <div class="col-md-10 col-12 d-flex justify-content-center align-items-center flex-wrap">
            
            <form id="formAgregarCliente" class="col-8">
                
                <div class="form-group">                        
                    <input type="text" class="form-control" name="nombre" placeholder="Nombres">
                </div>
                <div class="form-group">                        
                    <input type="email" class="form-control" name="correo" placeholder="Correo">
                </div>            
                <div class="form-group">                        
                    <input type="text" class="form-control" name="telefono" placeholder="Teléfono">
                </div>                                        
                               
                <button type="submit" class="btn btn-primary col-12 mt-4">Crear</button>
            </form>
        </div>
    </div>
</div>
@endsection