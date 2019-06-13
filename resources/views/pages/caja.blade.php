@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-sm-11  d-flex justify-content-center align-items-center flex-wrap">
            <div onclick="window.location.href='/crear-ticket'; return false;" class="tarjetas card pointer col-12 col-md-4 color1 text-white d-flex justify-content-center align-items-center">
                <div class="">Crear Ticket</div>              
                
            </div>
            <div onclick="window.location.href='/tickets-cajero'; return false;" class="tarjetas card ml-0 ml-md-2 pointer col-12 col-md-4 mt-2 mt-md-0 color2 text-white d-flex justify-content-center align-items-center">
                <div class="">Tickets</div>              
                
            </div>
            <div onclick="window.location.href='/cupones'; return false;" class="tarjetas card ml-0 ml-md-0 pointer col-12 col-md-4 mt-2 mt-md-2 color3 text-white d-flex justify-content-center align-items-center">
                <div class="">Cupones</div>              
                
            </div>
            <div onclick="window.location.href='/pagos'; return false;" class="tarjetas card ml-0 ml-md-2 pointer col-12 col-md-4 mt-2 mt-md-2 color4 text-white d-flex justify-content-center align-items-center">
                <div class="">Pagos</div>              
                
            </div>
        </div>
    </div>
</div>
@endsection