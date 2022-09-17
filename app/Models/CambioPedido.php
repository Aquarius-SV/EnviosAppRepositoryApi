<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambioPedido extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cambios_entregas';
    protected $primaryKey ='id';
    protected $fillable = [
        'fecha',
        'turno',        
        'id_pedido',        
    ];
}
