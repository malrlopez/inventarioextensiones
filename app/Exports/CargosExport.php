<?php

namespace App\Exports;

class CargosExport extends BaseExport
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->headings = [
            'Nombre',
            'Descripción',
            'Departamento',
            'Estado',
            'Última Actualización'
        ];
    }

    public function map($cargo): array
    {
        return [
            $cargo->nombre_cargo,
            $cargo->descripcion ?? 'N/A',
            $cargo->departamento ?? 'N/A',
            $cargo->estado,
            $cargo->updated_at ? $cargo->updated_at->format('d/m/Y H:i') : 'N/A'
        ];
    }
}
