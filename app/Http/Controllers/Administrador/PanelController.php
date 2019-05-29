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
                
        $idUsuario = $datos->idUsuario; 
        $fInicio  = $datos->fInicio; 
        $fFinal  = $datos->fFinal; 
        
        $query = "SELECT count(*) as 'cantTickets', item_id, created_at as fecha WHERE created_at (BETWEEN '$fInicio' AND '$fFinal')"; 

        if(isset($request->idUsuario)){ 
            $query .= " AND id = '$idUsuario'"; 
        }
        
        $tickets = DB::select($query); 

        foreach ($tickets as $ticket) {
            $cantTickets = $ticket->cantTickets;

            $item_ids = json_encode($ticket->item_id);

            foreach ($item_ids as $item) {
                
            }

            


        }
        

        return json_encode();
    }

}
