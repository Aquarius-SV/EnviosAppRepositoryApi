<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DireccionClienteModel extends Model
{
    use HasFactory;
    protected $table = 'direcciones_clientes';
    protected $primaryKey ='id';
    protected $fillable = [
        'nombre',
        'dui',
        'telefono',
        'direccion',
        'id_municipio',
        'referencia',
        'id_usuario',
        'numero_whatsapp',
        'correo',
        'id_comercio',
        'cod'
    ];
}
