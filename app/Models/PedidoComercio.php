<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoComercio extends Model
{
    use HasFactory;
    protected $table = 'pedidos_comercios';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_pedido',
        'id_comercio',                      
    ];
}
