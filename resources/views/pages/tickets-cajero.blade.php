@extends('layouts.app')

@section('content')
<div id="tickets" class="container">
    <button onclick="window.location.href='/home'; " class="btn btn-primary mb-4"><i class="fas fa-arrow-left mr-2"></i>Regresar</button>
    <div class="row">

        <div class="mb-4  d-flex justify-content-end align-items-center flex-wrap">                                
            <div class="form-group ml-2">      
                <label class="mr-2 float-right" for="fechaInicio">Fecha Inicio</label>              
                <input id="fechaInicio" type="date" class="form-control" value="{{ date("Y-m-d",strtotime(date('Y-m-d')."- 7 days")) }}">                    
            </div> 
            
            <div class="form-group ml-2">      
                <label class="mr-2 float-right" for="fechaFin">Fecha Fin</label>              
                <input id="fechaFin" type="date" class="form-control"  value="{{ date('Y-m-d') }}">                    
            </div> 
        </div>
        
        <div class="table-responsive">           
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col"># ID Ticket</th>
                        <th scope="col">Fecha</th>
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