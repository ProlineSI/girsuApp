<?php

namespace App\Http\Controllers;
use App\Participante;
use App\User;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TCP_Client {

            function __construct($ip, $port, $mensaje) {

                
                $sk =  @fsockopen($ip, $port,$errnum,$errstr,30);

                if (!is_resource($sk)) {
                     exit("connection fail: ".$errnum." ".$errstr) ;
                 } else {
 
                 echo "Connected";
                 $data_packet = $this->CreateDataPacket($mensaje);
                 foreach ($data_packet as $ele) {
                     $ret = fwrite($sk, $ele);
                     echo $ele;
                 }
                 }
            }

            function CustomMerge(&$target_array, $target_data) {
                foreach ($target_data as $key => $value) {
                    $target_array[count($target_array)] = chr($value);
                }
            }

            function CreateDataPacket($data) {
                $packet = array();
                $packet[count($packet)] = chr(2); //initialize
                $this->CustomMerge($packet, unpack('C*', strlen($data)));
                $packet[count($packet)] = chr(4); //separator
                $this->CustomMerge($packet, unpack('C*', $data));
                return $packet;
            }

        }
        
class webhookController extends Controller
{
    
   
    public function acreditar(Request $request){
        
        //obtenemos el id de eventbrite desde la url que nos envia el webhook
        
        if ($request->isMethod('post')){
            $id = $request->all();
            $id = str_replace("https://www.eventbriteapi.com/v3/events/idEvento/attendees/", "", $id['api_url']);
            $id = str_replace("/", "", $id);
        }
        
        //Participante::create(['nombre'=>'facundo','eventbrite_id'=>$id]);    ---esta linea sirve para crear un usuario directamente en la base de datos---
        
        //si eventbrite_id es igual al id que obtenemos del webhook entonces se cambia estadoParticipante a 1 (acreditado)
        
        if(Participante::where('eventbrite_id', $id)->exists()){
                
            Participante::where('eventbrite_id', $id)
                          ->update(['estadoParticipante' => 1]);
        
    
            //llamada a la funcion para imprimir la credencial
        
            $this->imprimirCredencial($id);
    
        }else{
            echo 'No se acredito';
        }
        
   }
   
   
   
   
   
   public function imprimirCredencial($idEventbrite)
   {
        $data = Participante::where('eventbrite_id', $idEventbrite)
                            ->get();
        $data = $data->toArray();
        $data = array_first($data);
        
        $nombre = $data['nombre'];
        $apellido = $data ['apellido'];
        $empresa = $data ['company'];
        $empleo = $data['empleo'];
        $celular = $data['celular'];
        $email = $data['email'];
        $ticketType = $data['ticket_type'];
        $dni = $data['dni'];
        $departamento = $data['workCity'];
        $provincia = $data['workState'];
        $ip = 'ip a configurar';
        $port = 'puerto a configurar';
        
        $zpl = '^XA'.
                  '^CFA,42'.
                  '^FO150,35^FD'.$ticketType.'^FS'.
                  '^CFA,32'.
                  '^FO50,110^FD'.$nombre.' '.$apellido.'^FS'.
                  '^CFA,23'. 
                  '^FO50,170^FD'.$empresa.'-'.$empleo.'^FS'.
                  '^FO250,250^FD'.$departamento.','.'^FS'.
                  '^FO250,275^FD'.$provincia.'^FS'.
                  '^FO50,132^BY2,2,95^BQ,2,3'.
                  '^FH_^FDHM,A'.$nombre.' '.$apellido.'/'.$empresa.'-'.$empleo.'/'.$celular.'/'.$email.'/'.$dni.'^FS'.
                  '^XZ';

           $obj_client = new TCP_Client($ip,$port,$zpl); 
   }
   
   public function imprimirCredencialVista($idEventbrite)
   {
        $data = Participante::where('eventbrite_id', $idEventbrite)
                            ->get();
        $data = $data->toArray();
        $data = array_first($data);
        
        $nombre = $data['nombre'];
        $apellido = $data ['apellido'];
        $empresa = $data ['company'];
        $empleo = $data['empleo'];
        $celular = $data['celular'];
        $email = $data['email'];
        $ticketType = $data['ticket_type'];
        $dni = $data['dni'];
        $departamento = $data['workCity'];
        $provincia = $data['workState'];
        $ip = 'ip a configurar';
        $port = 'puerto a configurar';
        
        $zpl = '^XA'.
                  '^CFA,42'.
                  '^FO150,35^FD'.$ticketType.'^FS'.
                  '^CFA,32'.
                  '^FO50,110^FD'.$nombre.' '.$apellido.'^FS'.
                  '^CFA,23'. 
                  '^FO50,170^FD'.$empresa.'-'.$empleo.'^FS'.
                  '^FO250,250^FD'.$departamento.','.'^FS'.
                  '^FO250,275^FD'.$provincia.'^FS'.
                  '^FO50,132^BY2,2,95^BQ,2,3'.
                  '^FH_^FDHM,A'.$nombre.' '.$apellido.'/'.$empresa.'-'.$empleo.'/'.$celular.'/'.$email.'/'.$dni.'^FS'.
                  '^XZ';

           $obj_client = new TCP_Client($ip,$port,$zpl); 
        
        return redirect()->back()->with('mensaje', 'Credencial impresa correctamente');

   }
   
   
   
   
   
   
}

