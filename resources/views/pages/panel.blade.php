@extends('layouts.app')

@section('content')
<div id="panel" class="container">
    <div class="row justify-content-center"> 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-12 row align-items-center justify-content-end">
            <div class="form-group col-12 col-md-5">
                <button class="btn mt-4 float-left" onclick="history.back();"><i class="fas fa-arrow-left mr-2"></i> Regresar</button>
            </div>
            <div class="form-group col-12 col-md-2 text-white">
                <label for="fInicio">Fecha Inicio</label>
                <select id="usuarios" class="form-control">
                    <option value="-1">Todos</option>
                </select>
            </div>
            <div class="form-group ml-1 col-12 col-md-2 text-white">
                <label for="fInicio">Fecha Inicio</label>
                <input id="fInicio" type="date" class="form-control" value="{{ date("Y-m-d",strtotime(date('Y-m-d')."- 7 days")) }}"> 
            </div>
            <div class="form-group ml-1 col-12 col-md-2 text-white">
                <label for="fFinal">Fecha Final</label>
                <input id="fFinal" type="date" class="form-control" value="{{ date('Y-m-d') }}"> 
            </div>
        </div>

        <div class="col-12 row justify-content-between mt-4">
            
            <div class="card col-12 col-md-3 col-lg-2 mt-2 mt-md-0">
                <div class="card-body">
                    <h5>Cant. de Tickets</h1>
                    <h2 id="cantTickets"></h2>
                </div>
            </div>
            <div class="card col-12 col-md-3 col-lg-2 mt-2 mt-md-0">
                <div class="card-body">
                    <h5>Total Facturado</h5>
                    <h2 id="totalFacturado"></h2>
                </div>
            </div>
            <div class="card col-12 col-md-3 col-lg-2 mt-2 mt-md-0">
                <div class="card-body">
                    <h5>Ganancia Neta</h5>
                    <h2 id="gananciaNeta"></h2>
                </div>
            </div>
            <div class="card col-12 col-md-3 col-lg-2 mt-2 mt-md-0">
                <div class="card-body">
                    <h5>Ganancia de usuario(s)</h5>
                    <h2 id="gananciaUsuario"></h2>
                </div>
            </div>
            <div class="card col-12 col-md-3 col-lg-2 mt-2 mt-md-0">
                <div class="card-body">
                    <h5>Venta de Productos</h5>
                    <h2 id="totalPrecioProductos"></h2>
                </div>
            </div>

        </div>
        

    </div>
</div>

<div id="tickets" class="container mt-5">
    <div class="row">
        
        <div class="table-responsive">           
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"># ID Tickets</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody id="tablaTickets"></tbody>
            </table>

        </div>
    </div>
</div>
@endsection