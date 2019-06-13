@extends('layouts.app')

@section('content')
<div id="adminServicios" class="container">
    <div class="row">        
        <div class="table-responsive">          
            <button onclick="window.location.href='/home'; " class="btn btn-primary mb-4"><i class="fas fa-arrow-left mr-2"></i>Regresar</button>  
            <div title='Nuevo Servicio' onclick="window.location.href='/agregar-servicio'" class="pointer text-center">
                <i class="agregarServicio fas fa-plus-circle text-white mb-4 pt-1"></i>
            </div>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"># ID Usuario</th>
                        <th scope="col">Servicio</th>
                        <th scope="col">Descripción</th>                        
                        <th scope="col">Precio</th>                        
                        <th scope="col">Descuento</th>                        
                        <th scope="col">Opciones</th>                        
                    </tr>
                </thead>
                <tbody id="tablaServicios"></tbody>
            </table>

        </div>
    </div>
</div>


@endsection