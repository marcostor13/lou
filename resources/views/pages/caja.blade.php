@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-10  d-flex justify-content-between align-items-center flex-wrap">
            <div onclick="window.location.href='/crear-ticket'; return false;" class="tarjetas card pointer col-12 col-md-4 color3 text-white d-flex justify-content-center align-items-center">
                <div class="">Crear Ticket</div>              
                
            </div>
            <div onclick="window.location.href='/tickets-usuario'; return false;" class="tarjetas card ml-0 pointer col-12 col-md-4 mt-2 mt-md-0 color4 text-white d-flex justify-content-center align-items-center">
                <div class="">Tickets</div>              
                
            </div>
        </div>
    </div>
</div>
@endsection