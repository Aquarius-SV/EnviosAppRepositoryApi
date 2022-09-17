<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogChangePedido extends Model
{
    use HasFactory;
    protected $table = 'change_log_pedido';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_pedido  ',
        'accion ',
        'id_repartidor',
        'id_zona',    
    ];
}
