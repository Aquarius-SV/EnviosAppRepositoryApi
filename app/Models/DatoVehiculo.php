<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatoVehiculo extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'datos_vehiculos';
    protected $primaryKey ='id';
    protected $fillable = [
        'tipo',
        'placa',
        'modelo',
        'marca',
        'color',
        'id_user',
        'peso',
        'size'
    ];
}
