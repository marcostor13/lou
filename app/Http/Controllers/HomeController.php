<?php

namespace Lou\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        
        if($request->user()->authorizeRoles('admin')){
            return view('pages/admin');
        }else if($request->user()->authorizeRoles('caja')){
            return view('pages/caja');
        }else{
            return view('pages/user'); 
        }
        
    }
}
