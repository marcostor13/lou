@extends('layouts.app')

@section('content')
<div id="adminClientes" class="container">
    <div class="row">        
        <div class="table-responsive">          
            <button onclick="window.location.href='/home'; " class="btn btn-primary mb-4"><i class="fas fa-arrow-left mr-2"></i>Regresar</button>  
            <div title='Nuevo Cliente' onclick="window.location.href='/agregar-cliente'" class="pointer text-center">
                <i class="agregarCliente fas fa-plus-circle text-white mb-4 pt-1"></i>
            </div>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"># ID Cliente</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Correo</th>                        
                        <th scope="col">Telefono</th>  
                        <th scope="col">Opciones</th>                        
                    </tr>
                </thead>
                <tbody id="tablaClientes"></tbody>
            </table>

        </div>
    </div>
</div>


@endsection