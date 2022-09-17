<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatoIntermediario extends Model
{
    use HasFactory;
    protected $table = 'datos_intermediarios';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_usuario',
        'dui',
        'direccion',
        'telefono',
        'cargo'       
    ];
}
