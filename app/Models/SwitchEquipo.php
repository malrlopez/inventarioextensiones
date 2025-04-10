<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SwitchEquipo extends Model
{
    use HasFactory;
    
    protected $table = 'switches';
    protected $primaryKey = 'id_switch';
    public $timestamps = false;
    
    protected $fillable = [
        'puerto_switche_asignado',
        'total_puertos',
        'puertos_disponibles',
        'vlan',
        'marca',
        'referencia',
        'id_rack'
    ];
    
    // Relación con Rack
    public function rack()
    {
        return $this->belongsTo(Rack::class, 'id_rack');
    }
}