<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtensionUbicacion extends Model
{
    use HasFactory;
    
    protected $table = 'extensionesubicaciones';
    public $timestamps = false;
    
    // Clave primaria compuesta
    protected $primaryKey = null;
    public $incrementing = false;
    
    protected $fillable = [
        'id_extension',
        'id_ubicacion',
        'fecha_asignacion'
    ];
    
    // No es necesario definir relaciones aquí ya que es una tabla pivote
}