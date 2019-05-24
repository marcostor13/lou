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


}
