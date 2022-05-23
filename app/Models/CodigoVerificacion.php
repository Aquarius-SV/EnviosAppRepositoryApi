<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoVerificacion extends Model
{
    use HasFactory;

    protected $table = 'codigos_verificacion';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_usuario',
        'cod',        
    ];
}
