<?php

namespace Lou\Http\Controllers\Administrador;

use Illuminate\Http\Request;
use Lou\Http\Controllers\Controller;
use DB;

class PanelController extends Controller
{
    public function obtenerUsuarios(Request $request){


        $users = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')            
            ->select('users.*', 'role_user.role_id as idRol')
            ->get();       
        

        return json_encode($users);
    }

    public function is_valid_email($str){
        $matches = null;
        return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
    }

    public function guardarUsuario(Request $request){
        
        if(!$this->is_valid_email($request->email)){
            return 'Correo inválido';
        }
        
        DB::table('users')
            ->where('id', $request->id)
            ->update([  'name' => $request->name,   
                        'email' => $request->email,
                        'password' => password_hash($request->password, PASSWORD_DEFAULT)
                        ]);

        DB::table('role_user')
            ->where('user_id', $request->id)
            ->update(['role_id' => $request->idRol]);          

        return 1;
    }

    public function crearUsuario(Request $request){
        
        if(!$this->is_valid_email($request->email)){
            return 'Correo inválido';
        }
        
        $id = DB::table('users')->insertGetId(
            ['email' => $request->email, 'name' => $request->name, 'password' => password_hash($request->password, PASSWORD_DEFAULT)]
        );

        DB::table('role_user')->insert(
            ['user_id' => $id, 'role_id' => $request->rol]
        );          

        return 1;
    }

    public function eliminarUsuario(Request $request){       
               
        DB::table('users')->where('id', '=', $request->id)->delete();
        DB::table('role_user')->where('user_id', '=', $request->id)->delete();
        return 1;
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
