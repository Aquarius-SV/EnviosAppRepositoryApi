<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $primaryKey ='id';
    protected $fillable = [
        'direccion_entrega',
        'direccion_recogida',
        'id_repartidor',
        'id_usuario',
        'estado',
        'created_at',
        'updated_at',
        'delivered_at',
        'motivo'
    ];
}
