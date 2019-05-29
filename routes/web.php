<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/crear-ticket', function () {
    return view('pages/crear-ticket');
});

Route::get('/agregar-cliente', function () {
    return view('pages/agregar-cliente');
});

Route::get('/tickets-usuario', function () {
    return view('pages/tickets-usuario');
});

Route::get('/tickets-admin', function () {
    return view('pages/tickets-admin');
});

Route::get('/panel-admin', function () {
    return view('pages/panel');
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//GENERALES
Route::post('obtenerDatosTabla', 'GeneralController@obtenerDatosTabla');

// TICKETS
Route::post('obtenerClientes', 'Usuario\TicketsController@obtenerClientes');
Route::post('crearTicket', 'Usuario\TicketsController@crearTicket');
Route::post('obtenerTickets', 'Usuario\TicketsController@obtenerTickets');
Route::post('guardarTickets', 'Usuario\TicketsController@guardarTickets');
Route::post('obtenerTicketsAdmin', 'Usuario\TicketsController@obtenerTicketsAdmin');
Route::post('obtenerDetalleTicket', 'Usuario\TicketsController@obtenerDetalleTicket');
Route::post('obtenerUsuarios', 'Administrador\PanelController@obtenerUsuarios');







