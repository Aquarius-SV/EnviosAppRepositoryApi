<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repartidor extends Model
{
    use HasFactory;
    protected $table = 'repartidores';
    protected $primaryKey ='id';
    protected $fillable = [
        'telefono',
        'dui',
        'nit',
        'licencia',
        'id_usuario',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function areas()
    {
        return $this->hasMany(DetalleZona::class, 'id_repartidor');
    }
}
