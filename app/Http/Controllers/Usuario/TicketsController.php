<?php

namespace Lou\Http\Controllers\Usuario;

use Illuminate\Http\Request;
use Lou\Http\Controllers\Controller;
use DB;

class TicketsController extends Controller
{
    public function obtenerClientes(Request $request){
        
        $query = "SELECT * FROM clientes"; 

        if(isset($request->idcliente)){ 
            $query .= " WHERE id = '$request->idcliente'"; 
        }

        if(isset($request->busqueda)){ 
            $query .= " WHERE nombre LIKE '%$request->busqueda%'"; 
        }        

        return json_encode(DB::select($query));
    }

    public function crearTicket(Request $request){

        if(!isset($request->cliente)){
            return "Faltan datos"; 
        }

        $cliente = $request->cliente;        
        $userID = $request->userID;        
        $idCliente = $request->idCliente;        
        $items = json_decode($request->items);      
        $idsItems = array();        

        foreach ($items as $item) {
            //si es producto o servicio
            $PS = substr($item->tipo, 0, -1);
            $columna = $PS.'_id'; 
            
            $idsItems[] = DB::table('items')->insertGetId(
                [ 
                    $columna => $item->id ,
                    'precio' => $item->precio ,
                    'cantidad' => $item->cantidad 
                ]
            );
        }
        
        $idsItems = json_encode($idsItems);       
        
        DB::table('tickets')->insert(
            [
                'user_id' => $userID, 
                'cliente_id' => $idCliente,
                'item_id' => $idsItems
            ]
        );

        return 'Ticket Creado';

    }


    public function obtenerTickets(Request $request){

        if(!isset($request->userID)){
            return "Faltan datos"; 
        }    
        
        $userID = $request->userID;           
        $fechaInicio = $request->fechaInicio;           
        $fechaFin = $request->fechaFin;     
        
        $fechaFin = date("Y-m-d",strtotime($fechaFin."+ 1 days"));
        
        $results = DB::select("SELECT tickets.id, tickets.user_id, tickets.cliente_id, tickets.item_id, tickets.created_at as 'fecha', clientes.nombre FROM tickets INNER JOIN clientes ON clientes.id = tickets.cliente_id WHERE tickets.created_at BETWEEN '$fechaInicio' AND '$fechaFin'");

        $tickets = array(); 

        if(count($results)<1){
            return json_encode(array(
                'estado' => '100',
                'datos' =>  'No hay resultados'
            ));
        }
        
        foreach ($results as $ticket) {
            
            $items = implode(',', json_decode($ticket->item_id));      

            $precio = DB::select("SELECT SUM(precio) as precio FROM items WHERE id IN ($items)"); 

            $precio = json_decode(json_encode($precio), true);

            $tickets[] = array(
                'cliente_id' => $ticket->cliente_id,
                'item_id' => $ticket->item_id,
                'fecha' => $ticket->fecha,
                'nombre' => $ticket->nombre,
                'precio' => $precio[0]['precio'],
                'ticket_id' => $ticket->id,
            );            
        }

        $res = array(
            'estado' => '200',
            'datos' =>  $tickets
        );

        return json_encode($res); 

    }

    public function obtenerItems(Request $request){

        if(!isset($request->items)){
            return "Faltan datos"; 
        }    
        
        $items = implode(',', json_decode($request->items));          
              
        $results = DB::select("SELECT items.precio, servicios.id as 'id_servicio', productos.id as 'id_producto', servicios.nombre as 'nombre_servicio', productos.nombre as 'nombre_producto' FROM items LEFT JOIN productos ON items.producto_id = productos.id LEFT JOIN servicios ON items.servicio_id = servicios.id WHERE items.id IN ($items)");

        $itemsRes = array(); 

        foreach ($results as $item) {
            
            $tipo = ($item->producto_id == 'NULL') ? 'servicio_id' : 'producto_id';
            $id = ($item->producto_id == 'NULL') ? $item->id_servicio : $item->id_producto;
            $nombre = ($item->producto_id == 'NULL') ? $item->nombre_servicio : $item->nombre_producto;
       
            $itemsRes[] = array(
                $tipo => $id,
                'precio' => $ticket->precio,                
                'nombre' => $nombre
            );        
            
        }

        return json_encode($itemsRes); 

    }

    public function obtenerDetalleTicket(Request $request){

        if(!isset($request->items)){
            return "Faltan datos"; 
        }    
                 
        $items = implode(',', json_decode($request->items));    
              
        $results = DB::select("SELECT items.cantidad, items.precio, servicios.id as 'id_servicio', productos.id as 'id_producto', servicios.nombre as 'nombre_servicio', productos.nombre as 'nombre_producto' FROM items LEFT JOIN productos ON items.producto_id = productos.id LEFT JOIN servicios ON items.servicio_id = servicios.id WHERE items.id IN ($items)");

        $itemsRes = array(); 

        //return json_encode($results);

        if(count($results)<1){
            return json_encode(array(
                'estado' => '100',
                'datos' =>  'No hay resultados'
            ));
        }

        
        

        foreach ($results as $item) {
                     
            $tipo = ($item->id_producto == null) ? 'servicio' : 'producto';
            $id = ($item->id_producto == null) ? $item->id_servicio : $item->id_producto;
            $nombre = ($item->id_producto == null) ? $item->nombre_servicio : $item->nombre_producto;
       
            $itemsRes[] = array(
                'idServicioProducto' => $id,
                'tipo' => $tipo,
                'nombre' => $nombre,
                'precio' => $item->precio,                
                'cantidad' => $item->cantidad                
            );                    
        }

        $res = array(
            'estado' => '200',
            'datos' =>  $itemsRes
        );

        return json_encode($res);

        

    }


}

