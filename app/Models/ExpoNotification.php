<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpoNotification extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'expo_notifications';
    protected $primaryKey ='id';
    protected $fillable = [
        'dispositivo',
        'expo_token',
        'id_user',
    ];
}
