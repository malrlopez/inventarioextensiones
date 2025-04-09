<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    use HasFactory;
    
    protected $table = 'extensiones';
    protected $primaryKey = 'id_extension';
    public $timestamps = false;
    
    protected $fillable = [
        'numero_extension',
        'tecnologia',
        'puerto',
        'cor',
        'id_empleado',
        'id_softphone',
        'id_ubicacion'
    ];
    
    // Relación con Empleado
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }
    
    // Relación con Softphone
    public function softphone()
    {
        return $this->belongsTo(Softphone::class, 'id_softphone');
    }
    
    // Relación con Ubicación
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion');
    }
    
    // Relación con HistorialCambios
    public function historialCambios()
    {
        return $this->hasMany(HistorialCambio::class, 'id_extension');
    }
    
    // Relación muchos a muchos con Ubicaciones
    public function ubicaciones()
    {
        return $this->belongsToMany(Ubicacion::class, 'extensionesubicaciones', 'id_extension', 'id_ubicacion')
                    ->withPivot('fecha_asignacion');
    }
}