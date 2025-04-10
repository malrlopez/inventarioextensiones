<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    
    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';
    public $timestamps = false;
    
    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'codigo_marcacion',
        'estado',
        'numero_cedula',
        'id_cargo',
        'id_sede'
    ];
    
    // Relación con Cargo
    public function cargo()
    {
        return $this->belongsTo(Cargo::class, 'id_cargo');
    }
    
    // Relación con Sede
    public function sede()
    {
        return $this->belongsTo(Sede::class, 'id_sede');
    }
    
    // Relación con Extensiones
    public function extensiones()
    {
        return $this->hasMany(Extension::class, 'id_empleado');
    }
}