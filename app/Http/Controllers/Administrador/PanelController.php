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

    public function agregarCliente(Request $request){
        
        if(!$this->is_valid_email($request->correo)){
            return 'Correo inválido';
        }

        $cliente = DB::table('clientes')
        ->where('nombre','=', $request->nombre)
        ->orwhere('correo','=', $request->correo)
        ->orwhere('telefono','=', $request->telefono)
        ->get();

        if(count($cliente)>0){
            return 'El cliente ya existe';
        }
        
        $id = DB::table('clientes')->insertGetId(
            ['correo' => $request->correo, 'nombre' => $request->nombre, 'telefono' => $request->telefono]
        );             

        return 1;
    }

    public function agregarServicio(Request $request){
          

        $cliente = DB::table('servicios')
        ->where('nombre','=', $request->nombre)        
        ->get();

        if(count($cliente)>0){
            return 'Ya existe un servicio con el mismo nombre';
        }
        
        $id = DB::table('servicios')->insertGetId(
            ['nombre' => $request->nombre, 'descripcion' => $request->descripcion, 'precio' => $request->precio, 'descuento' => $request->descuento]
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
        
        $fFinal = date("Y-m-d",strtotime($fFinal."+ 1 days")); 
        
        $query = "SELECT item_id, tickets.created_at as fecha, users.name as 'usuario' FROM tickets INNER JOIN users ON users.id = tickets.user_id WHERE (tickets.created_at BETWEEN '$fInicio' AND '$fFinal')"; 

       
        
        if(isset($request->idUsuario) AND $request->idUsuario != -1){ 
            $query .= " AND user_id = '$idUsuario'"; 
        }
        
        $tickets = DB::select($query); 

        $totalFacturado = 0;
        $gananciaNeta = 0;
        $totalDescuentos = 0;
        $cantTickets = 0; 

        $servCantidad = array(); 
        $usuarioTicket = array(); 

        foreach ($tickets as $ticket) {
            $cantTickets++;

            $item_ids = json_decode($ticket->item_id);
            $item_ids = implode(",", $item_ids);
            $q = "SELECT items.precio as 'precio', items.descuento as 'descuento', items.servicio_id as 'servicio_id', servicios.nombre as 'nombre' FROM items INNER JOIN servicios ON servicios.id = items.servicio_id WHERE items.id IN ($item_ids)"; 
            $items = DB::select($q); 
                       
            
            foreach ($items as $item) {
                
                $totalFacturado = $totalFacturado + $item->precio;
                $totalDescuentos = $totalDescuentos + $item->descuento;  
                $gananciaNeta = $gananciaNeta + ($item->precio - $item->descuento);
                $id = $item->servicio_id;     
                
                if(isset($servCantidad[$item->nombre])){
                    $servCantidad[$item->nombre] = $servCantidad[$item->nombre] + 1; 
                }else{
                    $servCantidad[$item->nombre] = 1;
                }
               
            }

            if(isset($usuarioTicket[$ticket->usuario])){
                $usuarioTicket[$ticket->usuario] = $usuarioTicket[$ticket->usuario] + 1; 
            }else{
                $usuarioTicket[$ticket->usuario] = 1;
            }

        }

        $gananciaAdmin = $gananciaNeta/2; 
        $gananciaUsuario = $gananciaNeta/2; 

        $datos = array(
            "cantTickets" => $cantTickets,
            "totalFacturado" => round($totalFacturado,2),
            "gananciaNeta" => round($gananciaAdmin,2),
            "gananciaUsuario" => round($gananciaUsuario,2),
            "totalDescuentos" => round($totalDescuentos,2),
            "servCantidad" => $servCantidad,
            "usuarioTicket" => $usuarioTicket,
        );


        
        return json_encode($datos);
    }

    public function obtenerServicios(Request $request){
        return json_encode(DB::table('servicios')->get());
    }

    public function guardarServicio(Request $request){
                    
        DB::table('servicios')
            ->where('id', $request->id)
            ->update([  'nombre' => $request->nombre,   
                        'descripcion' => $request->descripcion,
                        'precio' => $request->precio,
                        'descuento' => $request->descuento,
                        ]);   
        return 1;
    }

    public function eliminarServicio(Request $request){                      
        DB::table('servicios')->where('id', '=', $request->id)->delete();
        return 1;
    }



     public function obtenerClientes(Request $request){
        return json_encode(DB::table('clientes')->get());
    }

    public function guardarCliente(Request $request){
        
        if(!$this->is_valid_email($request->correo)){
            return 'Correo inválido';
        }
        
        DB::table('clientes')
            ->where('id', $request->id)
            ->update([  'nombre' => $request->nombre,   
                        'correo' => $request->correo,
                        'telefono' => $request->telefono,
                        ]);   
        return 1;
    }

    public function eliminarCliente(Request $request){                      
        DB::table('clientes')->where('id', '=', $request->id)->delete();
        return 1;
    }


    //CUPONES 

    public function obtenerCupones(Request $request){


        $users = DB::table('cupones')
            ->join('users', 'users.id', '=', 'cupones.user_id')            
            ->select('cupones.*', 'users.name as usuario')
            ->get();     

        return json_encode($users);
    }

    public function obtenerUsuariosSelect(Request $request){

        $users = DB::table('users')
        ->join('role_user', 'users.id', '=', 'role_user.user_id')     
        ->where('role_user.role_id', '=', '2')
        ->get();      
        return json_encode($users);
    }

    public function crearCupon(Request $request){
        
        DB::table('cupones')->insert(
            ['user_id' => $request->usuario, 'descripcion' => $request->descripcion, 'valor' => $request->valor]
        );          

        return 1;
    }

    public function obtenerPagos(Request $request){

               
        $idusuario = $request->usuario;           
        $fechaInicio = $request->fechaInicio;           
        $fechaFin = $request->fechaFin;     
        
        $fechaFin = date("Y-m-d",strtotime($fechaFin."+ 1 days"));
            

        if($idusuario == -1){
            $results = DB::select("SELECT tickets.id, tickets.user_id, tickets.cliente_id, tickets.item_id, tickets.created_at as 'fecha', users.name FROM tickets INNER JOIN users ON users.id = tickets.user_id WHERE  tickets.created_at BETWEEN '$fechaInicio' AND '$fechaFin'");
        }else{
            $results = DB::select("SELECT tickets.id, tickets.user_id, tickets.cliente_id, tickets.item_id, tickets.created_at as 'fecha', users.name FROM tickets INNER JOIN users ON users.id = tickets.user_id WHERE tickets.user_id = '$idusuario' AND tickets.created_at BETWEEN '$fechaInicio' AND '$fechaFin'");
        }

        
        if(count($results)<1){
            return json_encode(array(
                'estado' => '100',
                'datos' =>  'No hay resultados'
            ));
        }

        $subTotal = 0;
        
        
        foreach ($results as $ticket) {
            
            $items = implode(',', json_decode($ticket->item_id));      

            $precio = DB::select("SELECT SUM(precio-descuento) as precio,  SUM(descuento) as descuento FROM items WHERE id IN ($items)"); 

            $precio = json_decode(json_encode($precio), true);

            $subTotal = $subTotal + $precio[0]['precio'];
        }

        if($idusuario == -1){
             $cupones = DB::select("SELECT SUM(valor) as monto FROM cupones WHERE created_at BETWEEN '$fechaInicio' AND '$fechaFin'");
        }else{
             $cupones = DB::select("SELECT SUM(valor) as monto FROM cupones WHERE user_id = '$idusuario' AND created_at BETWEEN '$fechaInicio' AND '$fechaFin'");
        }

       $cupones = json_decode(json_encode($cupones), true);

        $pagos = array(
            'usuario' => $ticket->name,
            'subTotal' => $subTotal,
            'cupones' => $cupones[0]['monto'],
            'total' => $subTotal - $cupones[0]['monto'],
        ); 


        $res = array(
            'estado' => '200',
            'datos' =>  $pagos
        );

        return json_encode($res); 

    }

}
