@extends('layouts.app')

@section('content')
<div class="container">
    <button class="btn btn-primary mb-4"><i class="fas fa-arrow-left mr-2"></i>Regresar</button>
    <div class="row justify-content-center">
        
        <div class="col-md-8 col-sm-10 d-flex justify-content-center align-items-center flex-wrap">
            
            <form>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nombres">Nombre</label>
                        <input type="text" class="form-control" id="nombres" placeholder="Nombres">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" id="correo" placeholder="Correo">
                    </div>
                    
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" placeholder="Teléfono">
                    </div>                                        
                </div>                
                <button type="submit" class="btn btn-primary col-12 mt-4">Crear</button>
            </form>
        </div>
    </div>
</div>
@endsection