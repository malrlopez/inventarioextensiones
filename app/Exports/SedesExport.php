<?php

namespace App\Exports;

class SedesExport extends BaseExport
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->headings = [
            'Nombre',
            'Ciudad',
            'Dirección',
            'Teléfono',
            'Estado',
            'Última Actualización'
        ];
    }

    public function map($sede): array
    {
        return [
            $sede->nombre_sede,
            $sede->ciudad ?? 'N/A',
            $sede->direccion ?? 'N/A',
            $sede->telefono ?? 'N/A',
            $sede->estado,
      ]

    }
}
