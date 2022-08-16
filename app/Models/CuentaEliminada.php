<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaEliminada extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cuentas_eliminadas';
    protected $primaryKey ='id';
    protected $fillable = [
        'motivo',
        'descripcion',        
        'sugerencia',
        'id_usuario'
    ];
}
