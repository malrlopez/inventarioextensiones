<?php

namespace App\Exports;

class BloquesExport extends BaseExport
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->headings = [
            'Nombre',
            'Sede',
            'Descripción',
            'Estado',
            'Última Actualización'
        ];
    }

    public function map($bloque): array
    {
        return [
            $bloque->nombre_bloque,
            $bloque->sede ? $bloque->sede->nombre_sede : 'N/A',
            $bloque->descripcion ?? 'N/A',
            $bloque->estado,
            $bloque->updated_at ? $bloque->updated_at->format('d/m/Y H:i') : 'N/A'
        ];
    }
}
