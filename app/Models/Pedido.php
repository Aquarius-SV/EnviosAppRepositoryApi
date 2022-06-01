<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Mail\StatusPedido;
use Illuminate\Support\Facades\Mail;

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
        'motivo',
        'id_api_venta',
        'tel_cliente'
    ];



    public function emailToUsersPedido($toEmail,$numero,$state)
    {
        Mail::to($toEmail)->send(new StatusPedido($numero,$state));
    }
}
