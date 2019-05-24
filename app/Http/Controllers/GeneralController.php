<?php

namespace Lou\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GeneralController extends Controller
{
    //Recive el nombre de la tabla
    public function obtenerDatosTabla(Request $request){

        if(!isset($request->tabla)){
            return 'Falta parámetro "tabla"'; 
        }   
        $query = "SELECT * FROM $request->tabla";

        return json_encode(DB::select($query));
        
    }
    
}
