@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="table-responsive">

            <form class="col-12 mb-4 float-right d-flex justify-align-between align-items-center flex-wrap">
                                
                <div class="form-group ml-2">      
                    <label class="mr-2" for="inlineFormCustomSelectPref">Fecha Inicio</label>              
                    <input id="fechaInicio" type="date" class="form-control mr-2" value="{{ date("Y-m-d",strtotime(date('Y-m-d')."- 7 days")) }}">                    
                </div> 
                
                <div class="form-group ml-2">      
                    <label class="mr-2" for="inlineFormCustomSelectPref">Fecha Fin</label>              
                    <input id="fechaFin" type="date" class="form-control"  value="{{ date('Y-m-d') }}">                    
                </div> 

            </div>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Total</th>
                    </tr>
                </thead>
                <tbody id="tablaTickets">
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection