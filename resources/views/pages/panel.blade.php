@extends('layouts.app')

@section('content')
<div id="panel" class="container">
    <div class="row justify-content-center"> 
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="col-12 row justify-content-end">
            <div class="form-group col-12 col-md-3 text-white">
                <label for="fInicio">Fecha Inicio</label>
                <select id="usuarios" class="form-control">
                    <option value="-1">Todos</option>
                </select>
            </div>
            <div class="form-group ml-1 col-12 col-md-3 text-white">
                <label for="fInicio">Fecha Inicio</label>
                <input id="fInicio" type="date" class="form-control" value="{{ date("Y-m-d",strtotime(date('Y-m-d')."- 7 days")) }}"> 
            </div>
            <div class="form-group ml-1 col-12 col-md-3 text-white">
                <label for="fFinal">Fecha Final</label>
                <input id="fFinal" type="date" class="form-control" value="{{ date('Y-m-d') }}"> 
            </div>
        </div>

        <div class="col-12 row justify-content-between mt-4">
            
            <div class="card col-12 col-md-3 col-lg-2 mt-2 mt-md-0">
                <div class="card-body">
                    <h5>Cant. de Tickets</h1>
                    <h2 id="cantTickets">10</h2>
                </div>
            </div>
            <div class="card col-12 col-md-3 col-lg-2 mt-2 mt-md-0">
                <div class="card-body">
                    <h5>Total Facturado</h5>
                    <h2 id="totalFacturado">10</h2>
                </div>
            </div>
            <div class="card col-12 col-md-3 col-lg-2 mt-2 mt-md-0">
                <div class="card-body">
                    <h5>Ganancia Neta</h5>
                    <h2 id="gananciaNeta">10</h2>
                </div>
            </div>
            <div class="card col-12 col-md-3 col-lg-2 mt-2 mt-md-0">
                <div class="card-body">
                    <h5>Ganancia de usuario(s)</h5>
                    <h2 id="gananciaUsuario">10</h2>
                </div>
            </div>

        </div>
        

    </div>
</div>
@endsection