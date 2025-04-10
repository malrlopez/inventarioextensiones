<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    
    protected $table = 'cargos';
    protected $primaryKey = 'id_cargo';
    public $timestamps = false;
    
    protected $fillable = [
        'nombre_cargo'
    ];
    
    // Relación con Empleados
    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'id_cargo');
    }
}