<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoRetorno extends Model
{
    use HasFactory;
    protected $table = 'codigos_retornos';
    protected $primaryKey ='id';
    protected $fillable = [
        'cod',
        'id_pedido',       
    ];
}
