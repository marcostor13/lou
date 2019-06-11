@extends('layouts.app')

@section('content')
<div id="crearUsuarios" class="container">
    <button onclick="window.location.href='/administrar-usuarios'; " class="btn btn-primary mb-4"><i class="fas fa-arrow-left mr-2"></i>Regresar</button>
    <div class="row justify-content-center">              
            <form id="formCrearUsuario" class="col-12 col-sm-6">
                <div class="form-group">                  
                  <input type="text" name="name" class="form-control" placeholder="Nombre" autocomplete="off">                  
                </div>
                <div class="form-group">                  
                  <input type="email" name="email" class="form-control" placeholder="Correo" autocomplete="off">                  
                </div>
                <div class="form-group">                  
                  <input type="password" name="password" class="form-control" placeholder="Contraseña" autocomplete="new-password">                  
                </div>
                <div class="form-group">                  
                    <select name="rol"  class="form-control">                    
                        <option value="2">Usuario</option>
                        <option value="3">Cajero</option>
                        <option value="1">Administrador</option>
                    </select>                  
                </div>
                <div class="form-group">
                    <button type="submit" class="btn1 form-control">Crear Usuario</button>
                </div>

                <div class="respuestaCrearUsuario"></div>


            </form>        
    </div>
</div>


@endsection