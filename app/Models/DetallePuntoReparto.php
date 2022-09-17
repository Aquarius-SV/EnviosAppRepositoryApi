<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePuntoReparto extends Model
{
    use HasFactory;
    protected $table = 'detalles_puntos_repartos';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_punto_reparto ',
        'id_usuario ',       
    ];
}
