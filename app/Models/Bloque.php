<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    use HasFactory;

    protected $table = 'bloques';
    protected $primaryKey = 'id_bloque';
    public $timestamps = false;

    protected $fillable = [
        'nombre_bloque',
        'id_sede'
    ];

    public static $rules = [
        'nombre_bloque' => 'required|unique:bloques,nombre_bloque',
        'id_sede' => 'required|exists:sedes,id'
    ];

    // Relación con Sede
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'id_sede');
    }

    // Relación con Ubicaciones
    public function ubicaciones()
    {
        return $this->hasMany(Ubicacion::class, 'id_bloque');
    }
}
