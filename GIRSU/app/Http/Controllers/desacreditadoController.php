<?php


namespace App\Http\Controllers;
use App\Participante;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class desacreditadoController extends Controller
{
    
public function desacreditar(Request $request){
        
        if ($request->isMethod('post')){
            $id = $request->all();
            $id = str_replace("https://www.eventbriteapi.com/v3/events/idEvento/attendees/", "", $id['api_url']);
            $id = str_replace("/", "", $id);
            //echo $id;
            //print_r($id['config']['user_id']);
        }
        
        
        if(Participante::where('eventbrite_id', $id)->exists()){
                
            Participante::where('eventbrite_id', $id)
                          ->update(['estadoParticipante' => 0]);
            
             print_r(Participante::where('eventbrite_id', $id)->get());
    
        }else{
            echo 'No se desacredito';
        }
        
   }
   
}