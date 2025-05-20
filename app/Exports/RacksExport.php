<?php

namespace App\Exports;

class RacksExport extends BaseExport
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->headings = [
            'Nombre',
            'Ubicación',
            'Sede',
            'Descripción',
            'Estado',
            'Última Actualización'
        ];
    }

    public function map($rack): array
    {
        return [
            $rack->nombre,
            $rack->ubicacion ? $rack->ubicacion->oficina : 'N/A',
            $rack->ubicacion && $rack->ubicacion->sede ? $rack->ubicacion->sede->nombre_sede : 'N/A',
            $rack->descripcion ?? 'N/A',
            $rack->estado,
            $rack->updated_at ? $rack->updated_at->format('d/m/Y H:i') : 'N/A'
        ];
    }
}
