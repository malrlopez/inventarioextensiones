<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    use HasFactory;
    
    protected $table = 'racks';
    protected $primaryKey = 'id_rack';
    public $timestamps = false;
    
    protected $fillable = [
        'marca',
        'referencia',
        'id_ubicacion'
    ];
    
    // Relación con Ubicación
    public function ubicacion()
    {
        return $this->belongsTo(Ubicacion::class, 'id_ubicacion');
    }
    
    // En app/Models/Rack.php
public function switches()
{
    return $this->hasMany(SwitchEquipo::class, 'id_rack');
}
}