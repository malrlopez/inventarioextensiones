<?php

namespace App\Exports;

class UbicacionesExport extends BaseExport
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->headings = [
            'Oficina',
            'Sede',
            'Piso',
            'Descripción',
            'Estado',
            'Última Actualización'
        ];
    }

    public function map($ubicacion): array
    {
        return [
            $ubicacion->oficina,
            $ubicacion->sede ? $ubicacion->sede->nombre_sede : 'N/A',
            $ubicacion->piso ?? 'N/A',
            $ubicacion->descripcion ?? 'N/A',
            $ubicacion->estado,
            $ubicacion->updated_at ? $ubicacion->updated_at->format('d/m/Y H:i') : 'N/A'
        ];
    }
}
