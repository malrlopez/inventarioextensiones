<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    use HasFactory;
    
    protected $table = 'ubicaciones';
    protected $primaryKey = 'id_ubicacion';
    public $timestamps = false;
    
    protected $fillable = [
        'planta_telefonica',
        'cuarto_tecnico',
        'rack',
        'patch_panel',
        'faceplate',
        'oficina',
        'id_sede',
        'id_bloque'
    ];
    
    // Relación con Sede
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'id_sede');
    }
    
    // Relación con Bloque
    public function bloque()
    {
        return $this->belongsTo(Bloque::class, 'id_bloque');
    }
    
    // Relación con Extensiones
    public function extensiones()
    {
        return $this->hasMany(Extension::class, 'id_ubicacion');
    }
    
    // Relación con Racks
    public function racks()
    {
        return $this->hasMany(Rack::class, 'id_ubicacion');
    }
    
    // Relación muchos a muchos con Extensiones
    public function extensionesRelacionadas()
    {
        return $this->belongsToMany(Extension::class, 'extensionesubicaciones', 'id_ubicacion', 'id_extension')
                    ->withPivot('fecha_asignacion');
    }
}