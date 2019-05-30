<?php

namespace Lou\Http\Controllers\Administrador;

use Illuminate\Http\Request;
use Lou\Http\Controllers\Controller;
use DB;

class PanelController extends Controller
{
    public function obtenerUsuarios(Request $request){
        
        $query = "SELECT id, name FROM users"; 

        if(isset($request->idUsuario)){ 
            $query .= " WHERE id = '$request->idUsuario'"; 
        }            

        return json_encode(DB::select($query));
    }

    public function obtenerDatosPanel(Request $request){

        if(!isset($request->idUsuario) || !isset($request->fInicio) || !isset($request->fFinal)){
            return "Faltan datos"; 
        } 
                
        $idUsuario = $request->idUsuario; 
        $fInicio  = $request->fInicio; 
        $fFinal  = $request->fFinal; 
        
        $query = "SELECT item_id, created_at as fecha FROM tickets WHERE (created_at BETWEEN '$fInicio' AND '$fFinal')"; 

       
        
        if(isset($request->idUsuario) AND $request->idUsuario != -1){ 
            $query .= " AND user_id = '$idUsuario'"; 
        }
        
        $tickets = DB::select($query); 

        $totalFacturado = 0;
        $gananciaNeta = 0;
        $totalPrecioProductos = 0;
        $cantTickets = 0; 

        foreach ($tickets as $ticket) {
            $cantTickets++;

            $item_ids = json_decode($ticket->item_id);
            $item_ids = implode(",", $item_ids);
            $q = "SELECT * FROM items WHERE id IN ($item_ids)"; 
            $items = DB::select($q); 
            
            foreach ($items as $item) {
                
                $totalFacturado = $totalFacturado + $item->precio;
               
                if($item->producto_id != NULL){
                    $id = $item->producto_id;         
                    $totalPrecioProductos = $totalPrecioProductos +$item->precio; 
                }else{
                    $gananciaNeta = $gananciaNeta + $item->precio;
                    $id = $item->servicio_id; 
                }
               
            }

        }

        $gananciaNeta = $gananciaNeta/2; 
        $gananciaUsuario = $gananciaNeta/2; 

        $datos = array(
            "cantTickets" => $cantTickets,
            "totalFacturado" => $totalFacturado,
            "gananciaNeta" => $gananciaNeta,
            "gananciaUsuario" => $gananciaUsuario,
            "totalPrecioProductos" => $totalPrecioProductos
        );


        
        return json_encode($datos);
    }

}
