<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoPunto extends Model
{
    use HasFactory;
    protected $table = 'pedidos_puntos';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_pedido',
        'id_punto',
        'estado',
        'id_repartidor',
        'id_punto_pedido',
        'show_pedido'  
    ];
}
