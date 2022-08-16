<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleZona extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'detalles_zonas';
    protected $primaryKey ='id';
    protected $fillable = [
        'id_repartidor',
        'id_zona',        
    ];
    public function repartidor()
    {
        return $this->belongsTo(Repartidor::class);
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class, 'id_zona', 'id');
    }
}
