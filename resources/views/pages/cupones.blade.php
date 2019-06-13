@extends('layouts.app')

@section('content')
<div id="cupones" class="container">
    <div class="row">

        <button class="btn mt-4 float-left" onclick="window.location.href='/home'; "><i class="fas fa-arrow-left mr-2"></i> Regresar</button>
        
        <div class="table-responsive mt-4">     
            <div title='Nuevo Cupon' onclick="window.location.href='/agregar-cupon'" class="pointer text-center">
                <i class="agregar agregarCupon fas fa-plus-circle  text-white mb-4 pt-1"></i>
            </div>      
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"># ID cupones</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Valor</th>
                    </tr>
                </thead>
                <tbody id="tablaCupones"></tbody>
            </table>

        </div>
    </div>
</div>
@endsection