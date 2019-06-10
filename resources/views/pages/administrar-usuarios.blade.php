@extends('layouts.app')

@section('content')
<div id="adminUsuarios" class="container">
    <div class="row">        
        <div class="table-responsive">          
            
            <div title='Nuevo Usuario' onclick="window.location.href='/agregar-usuario'" class="pointer text-center">
                <i class="agregarUsuario fas fa-plus-circle text-white mb-4 pt-1"></i>
            </div>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"># ID Usuario</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>                        
                        <th scope="col">Contraseña</th>                        
                        <th scope="col">Rol</th>                        
                        <th scope="col">Opciones</th>                        
                    </tr>
                </thead>
                <tbody id="tablaUsuarios"></tbody>
            </table>

        </div>
    </div>
</div>


@endsection