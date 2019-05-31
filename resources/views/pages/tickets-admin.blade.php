@if(!Auth::user()->hasRole('admin'))
    <script>window.location.href = '/';</script>
@endif

@extends('layouts.app')

@section('content')
<div id="tickets" class="container">
    <div class="row">

        <div class="mb-4  row justify-content-end align-items-center flex-wrap col-12">                                
            <div class="form-group  col-12 col-md-5">
                <button class="btn mt-4 float-left" onclick="history.back();"><i class="fas fa-arrow-left mr-2"></i> Regresar</button>
            </div>
            <div class="form-group col-12 col-md-3">      
                <label class="mr-2 float-right" for="fechaInicio">Fecha Inicio</label>              
                <input id="fechaInicio" type="date" class="form-control" value="{{ date("Y-m-d",strtotime(date('Y-m-d')."- 7 days")) }}">                    
            </div> 
            
            <div class="form-group col-12 col-md-3">      
                <label class="mr-2 float-right" for="fechaFin">Fecha Fin</label>              
                <input id="fechaFin" type="date" class="form-control"  value="{{ date('Y-m-d') }}">                    
            </div> 
        </div>
        
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