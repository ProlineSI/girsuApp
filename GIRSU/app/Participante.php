<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Participante extends Authenticatable
{
    use Notifiable;
    
    //protected $table = "part_prueba";
    protected $table = "participantes";
    protected $primaryKey = "participante_id";
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'eventbrite_id',
        'nombre',
        'apellido',
        'email',
        'ticket_type',
        'celular',
        'dni',
        'ponencia',
        'entidadP',
        'solicitudEspacioFeria',
        'solicitudTrasladoTerrestre',
        'areaDeInteres',
        'empleo',
        'company',
        'workAdress1',
        'workAdress2',
        'workCity',
        'workState',
        'workCountry',
    ];

}