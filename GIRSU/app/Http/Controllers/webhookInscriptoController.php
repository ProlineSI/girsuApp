<?php

namespace App\Http\Controllers;
use App\Participante;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class webhookInscriptoController extends Controller
{

    public function inscribir(Request $request){
       if ($request->isMethod('post')){
            $id = $request->all();
            $id = str_replace("https://www.eventbriteapi.com/v3/events/idEvento/attendees/", "", $id['api_url']);
            $id = str_replace("/", "", $id);
       }
            
            $participante = Participante::where('eventbrite_id',$id)->get()->count();
           if($participante==0){
               
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, "https://www.eventbriteapi.com/v3/events/idEvento/attendees/$id/");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                  "Authorization: Bearer PERSONAL TOKEN",
                  "Content-Type: application/json"
                ));
                
                $response = curl_exec($ch);
                curl_close($ch);
                $response= json_decode($response);
                
                $idEventbrite = $response->id;
                $nombre = $response->profile->first_name;
                $apellido = $response->profile->last_name;
                $email = $response->profile->email;
                $ticket_type= $response->ticket_class_name;
                $celular= $response->profile->cell_phone;
                $dni = $response->answers[0]->answer;
                $ponencia = $response->answers[1]->answer;
                $entidadP = $response->answers[2]->answer;
                $solEspFeria = $response->answers[3]->answer;
                $solTrasTerr = $response->answers[4]->answer;
                $areaInteres = $response->answers[5]->answer;
                $empleo= $response->profile->job_title;
                $company= $response->profile->company;
                $workAddress1= $response->profile->addresses->work->address_1;
              if(isset($response->profile->addresses->work->address_2)){  $workAddress2=$response->profile->addresses->work->address_2; } else {$workAddress2 = "";}
                $city= $response->profile->addresses->work->city;
              if(isset( $response->profile->addresses->work->region)){ $region= $response->profile->addresses->work->region; } else {$region = "";}
                $postalCode= $response->profile->addresses->work->postal_code;
                $country= $response->profile->addresses->work->country;
               
               Participante::create(['eventbrite_id'=>$idEventbrite,
                             'nombre'=>$nombre,
                             'apellido'=>$apellido,
                             'email'=>$email,
                             'ticket_type'=>$ticket_type,
                             'celular'=>$celular,
                             'dni'=>$dni,
                             'ponencia'=>$ponencia,
                             'entidadP'=>$entidadP,
                             'solicitudEspacioFeria'=>$solEspFeria,
                             'solicitudTrasladoTerrestre'=>$solTrasTerr,
                             'areaDeInteres'=>$areaInteres,
                             'empleo'=>$empleo,
                             'company'=>$company,
                             'workAdress1'=>$workAddress1,
                             'workAdress2'=>$workAddress2,
                             'workCity'=>$city,
                             'workState'=>$region,
                             'workCountry'=>$country]);   
               
               
               echo 'se creo correctamente';
               
           }else{
               echo 'Ya existe, no se puede agregar';
               
           }
           
           
           
          
 
    }
    
    
}