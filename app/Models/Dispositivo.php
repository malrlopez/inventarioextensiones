<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispositivo extends Model
{
    protected $table = 'dispositivos';
    protected $primaryKey = 'id_dispositivo';

    protected $fillable = [
        'nombre',
        'tipo',
        'estado',
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
