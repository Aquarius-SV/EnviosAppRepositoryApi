<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direcciones';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_usuario ',
        'nombre',
        'direccion',
        'id_comercio',
        'id_municipio'
    ];
}
