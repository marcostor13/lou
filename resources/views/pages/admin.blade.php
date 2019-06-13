@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-sm-12 d-flex justify-content-center align-items-center flex-wrap">
            <div onclick="window.location.href='/panel-admin'; return false;" class="tarjetas card pointer col-12 col-md 6 color2 text-white d-flex justify-content-center align-items-center">
                <div class="text-center">Panel Principal</div>              
                
            </div>            
            <div onclick="window.location.href='/crear-ticket'; return false;" class="tarjetas card ml-0 ml-md-5 mt-4 mt-md-0 pointer col-12 col-md 6 color3 text-white d-flex justify-content-center align-items-center">
                <div class="text-center">Crear Ticket</div>              
                
            </div>
            <div onclick="window.location.href='/administrar-usuarios'; return false;" class="tarjetas card ml-0 ml-md-5 mt-4 mt-md-0 pointer col-12 col-md 6 color4 text-white d-flex justify-content-center align-items-center">
                <div class="text-center">Administrar Usuarios</div>      
                
            </div>
            <div onclick="window.location.href='/administrar-servicios'; return false;" class="tarjetas card ml-0 ml-md-5 mt-4 mt-md-0 pointer col-12 col-md 6 color4 text-white d-flex justify-content-center align-items-center">
                <div class="text-center">Servicios</div>              
                
            </div>

            <div onclick="window.location.href='/administrar-clientes'; return false;" class="tarjetas card ml-0 ml-md-5 mt-4 mt-md-0 pointer col-12 col-md 6 color4 text-white d-flex justify-content-center align-items-center">
                <div class="text-center">Clientes</div>              
                
            </div>
            
        </div>
    </div>
</div>
@endsection