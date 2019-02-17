<?php

namespace App\Http\Controllers;

use App\Participante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Mail;
use Yajra\Datatables\Datatables;

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
    public function index()
    {
        $user = Auth::user()->name;
        $participantes = Participante::where('estadoParticipante','=', 1)->get();
        return view('home',compact('user','participantes'));
    }
    
    public function dataTableAcreditados(){
        $participantes = Participante::select(['eventbrite_id', 'nombre', 'apellido', 'email', 'ticket_type', 'celular', 'dni', 'empleo', 'company', 'workAdress1', 'workCity', 'workState', 'workCountry'])->where('estadoParticipante','=',1);
        return Datatables::of($participantes)->make(true);
    }
    
    public function mailVirtualIndividual(Request $request){
        //busca usuario por id
        $id = $request['id'];
        $participante = Participante::where('eventbrite_id','=', $id)->get()->first();
        //Arma el pdf
        $pdf = PDF::loadView('certificados.layoutcert', compact('participante'))->setPaper('a4', 'landscape');
        //Manda mail automaticamente
        Mail::send(['text'=>'certificados.textoMail'],['name' => 'GIRSU II'], function($mensage) use($pdf, $participante){
            $mensage->to($participante->email, $participante->nombre . ' ' . $participante->apellido)->subject('Certificado Congreso Girsu II - '. $participante->nombre . ' ' . $participante->apellido);
            $mensage->from('nicobaudon01@gmail.com', 'Nicolás');
            $mensage->attachData($pdf->output(),'Certificado '. $participante->nombre . ' ' . $participante->apellido .'.pdf');
        });
        return \Response::json();
    }
    public function imprimirPreImpreso($id){
        //busca usuario por id
        $participante = Participante::where('eventbrite_id', $id)->get()->first();
        $pdf = PDF::loadView('certificados.layoutcertPre', compact('participante'))->setPaper('a4', 'landscape');
        return $pdf->stream('Certificado '. $participante->nombre . ' ' . $participante->apellido .'.pdf');
    }
    public function mailGral(Request $request){
        $ids= $request->check_mail;
        foreach($ids as $id){
            $participante = Participante::where('eventbrite_id', $id)->get()->first();
            //Arma el pdf
            $pdf = PDF::loadView('certificados.layoutcert', compact('participante'))->setPaper('a4', 'landscape');
            //Manda mail automaticamente
            Mail::send(['text'=>'certificados.textoMail'],['name' => 'GIRSU II'], function($mensage) use($pdf, $participante){
                $mensage->to($participante->email, $participante->nombre . ' ' . $participante->apellido)->subject('Certificado Congreso Girsu II - '. $participante->nombre . ' ' . $participante->apellido);
                $mensage->from('nicobaudon01@gmail.com', 'Nicolás');
                $mensage->attachData($pdf->output(),'Certificado '. $participante->nombre . ' ' . $participante->apellido .'.pdf');
            });
        }
        return redirect()->back()->with('mensaje', 'Emails enviados correctamente');
    }
    public function impresionGral(Request $request){
        /*$ids= $request->check_impresion;
        foreach($ids as $id) {
            $participante= Participante::where('eventbrite_id', $id)->get()->first();
            $pdf = PDF::loadView('certificados.layoutcertPre', compact('participante'))->setPaper('a4', 'landscape')->save('C:\Users\nicob\Desktop\certificados\Certificado '. $participante->nombre . ' ' . $participante->apellido .'.pdf');
        }*/
        return redirect()->back()->with('mensaje', 'PDFs Generados Correctamente');
    }

}
