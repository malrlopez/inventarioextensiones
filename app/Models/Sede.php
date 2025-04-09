<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;
    
    protected $table = 'sedes';
    protected $primaryKey = 'id_sede';
    public $timestamps = false;
    
    protected $fillable = [
        'nombre_sede',
        'direccion'
    ];
    
    // Relación con Bloques
    public function bloques()
    {
        return $this->hasMany(Bloque::class, 'id_sede');
    }
    
    // Relación con Empleados
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_sede');
    }
    
    // Relación con Ubicaciones
    public function ubicaciones()
    {
        return $this->hasMany(Ubicacion::class, 'id_sede');
    }
}