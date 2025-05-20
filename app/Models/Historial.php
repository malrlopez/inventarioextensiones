<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'historial';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_id',
        'tabla',
        'accion',
        'registro_id',
        'detalles',
    ];

    /**
     * Obtiene el usuario asociado al cambio.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function extension()
    {
        return $this->belongsTo(Extension::class, 'registro_id', 'id_extension');
    }
}
