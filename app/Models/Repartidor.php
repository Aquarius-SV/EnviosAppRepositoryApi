<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repartidor extends Model
{
    use HasFactory;
    protected $table = 'repartidores';
    protected $primaryKey ='id';
    protected $fillable = [
        'telefono',
        'dui',
        'nit',
        'licencia',
        'id_usuario'
    ];
}
