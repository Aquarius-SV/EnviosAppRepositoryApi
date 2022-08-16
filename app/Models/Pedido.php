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
        'delivered_at',
        'motivo',
        'id_api_venta',
        'tel_cliente',
        'tipo_embalaje',
        'peso',
        'fragil',
        'alto',
        'ancho',
        'nombre_cliente',
        'negocio',
        'profundidad',
        'envio',
        'dui',
        'id_municipio',
        'referencia'
    ];



    public function emailToUsersPedido($toEmail,$numero,$state)
    {
        Mail::to($toEmail)->send(new StatusPedido($numero,$state));
    }
}
