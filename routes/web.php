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
    return view('/auth/login');
});

Route::get('/crear-ticket', function () {
    return view('pages/crear-ticket');
})->middleware('auth', 'role:user;admin;caja');;

Route::get('/agregar-cliente', function () {
    return view('pages/agregar-cliente');
})->middleware('auth', 'role:user;admin;caja');


Route::get('/tickets-usuario', function () {
    return view('pages/tickets-usuario');
})->middleware('auth', 'role:user;caja');

Route::get('/tickets-admin', function () {
    return view('pages/tickets-admin');
})->middleware('auth', 'role:admin');

Route::get('/panel-admin', function () {
    return view('pages/panel');
})->middleware('auth', 'role:admin');

Route::get('/administrar-usuarios', function () {
    return view('pages/administrar-usuarios');
})->middleware('auth', 'role:admin');

Route::get('/caja', function () {
    return view('pages/caja');
})->middleware('auth', 'role:caja');

Route::get('/agregar-usuario', function () {
    return view('pages/agregar-usuario');
})->middleware('auth', 'role:admin');

Route::get('/administrar-servicios', function () {
    return view('pages/administrar-servicios');
})->middleware('auth', 'role:admin');

Route::get('/agregar-servicio', function () {
    return view('pages/agregar-servicio');
})->middleware('auth', 'role:admin');

Route::get('/administrar-clientes', function () {
    return view('pages/administrar-clientes');
})->middleware('auth', 'role:admin');

Route::get('/tickets-cajero', function () {
    return view('pages/tickets-cajero');
})->middleware('auth', 'role:caja');

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
Route::post('guardarUsuario', 'Administrador\PanelController@guardarUsuario');
Route::post('crearUsuario', 'Administrador\PanelController@crearUsuario');
Route::post('eliminarUsuario', 'Administrador\PanelController@eliminarUsuario');
Route::post('obtenerDatosPanel', 'Administrador\PanelController@obtenerDatosPanel');
Route::post('agregarCliente', 'Administrador\PanelController@agregarCliente');
Route::post('agregarServicio', 'Administrador\PanelController@agregarServicio');
Route::post('obtenerServicios', 'Administrador\PanelController@obtenerServicios');
Route::post('obtenerClientes', 'Administrador\PanelController@obtenerClientes');
Route::post('guardarServicio', 'Administrador\PanelController@guardarServicio');
Route::post('guardarCliente', 'Administrador\PanelController@guardarCliente');
Route::post('eliminarServicio', 'Administrador\PanelController@eliminarServicio');
Route::post('eliminarCliente', 'Administrador\PanelController@eliminarCliente');







