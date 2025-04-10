<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Softphone extends Model
{
    use HasFactory;
    
    protected $table = 'softphones';
    protected $primaryKey = 'id_softphone';
    public $timestamps = false;
    
    protected $fillable = [
        'usuario',
        'dispositivo',
        'clave_softphone'
    ];
    
    // Relación con Extensiones
    public function extensiones()
    {
        return $this->hasMany(Extension::class, 'id_softphone');
    }
}