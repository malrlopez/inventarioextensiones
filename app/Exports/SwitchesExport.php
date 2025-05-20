<?php

namespace App\Exports;

class SwitchesExport extends BaseExport
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->headings = [
            'Nombre',
            'Marca',
            'Modelo',
            'Número de Serie',
            'Puertos',
            'IP',
            'Estado',
            'Última Actualización'
        ];
    }

    public function map($switch): array
    {
        return [
            $switch->nombre,
            $switch->marca ?? 'N/A',
            $switch->modelo ?? 'N/A',
            $switch->numero_serie ?? 'N/A',
            $switch->puertos ?? 'N/A',
            $switch->ip ?? 'N/A',
            $switch->estado,
            $switch->updated_at ? $switch->updated_at->format('d/m/Y H:i') : 'N/A'
        ];
    }
}
