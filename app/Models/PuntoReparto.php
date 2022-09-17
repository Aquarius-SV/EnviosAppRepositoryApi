<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntoReparto extends Model
{
    use HasFactory;
    protected $table = 'puntos_repartos';
    protected $primaryKey ='id';
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'id_municipio',
        'codigo',
        'correo_empresarial',
        'nombre_empresa',
        'nombre_propietario'
    ];
}
