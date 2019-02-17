<?php

namespace App\Http\Controllers;

use App\Participante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Mail;
use Yajra\Datatables\Datatables;

class InscriptosController extends Controller
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
    public function index()
    {
        $user = Auth::user()->name;
        $participantes = Participante::all();
        $participantes= $participantes->toArray();
        return view('inscriptos',compact('user','participantes'));
    }
    
    public function dataTableInscriptos(){
        $participantes = Participante::select(['eventbrite_id', 'nombre', 'apellido', 'email', 'ticket_type', 'celular', 'dni', 'empleo', 'company', 'workAdress1', 'workCity', 'workState', 'workCountry']);
        return Datatables::of($participantes)->make(true);
    }
}