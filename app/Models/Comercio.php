<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comercio extends Model
{
    use HasFactory;
    protected $table = 'comercios';
    protected $primaryKey ='id';
    protected $fillable = [
        'nombre',
        'telefono',
        'direccion',
        'dui',
        'telefono_encargado',
        'id_usuario',
        'id_municipio',
        'cod',
    ];
}
