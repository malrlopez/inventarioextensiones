<?php

namespace App\Exports;

class EmpleadosExport extends BaseExport
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->headings = [
            'Nombre',
            'Apellido',
            'Cargo',
            'Email',
            'Teléfono',
            'Estado',
            'Última Actualización'
        ];
    }

    public function map($empleado): array
    {
        return [
            $empleado->nombre,
            $empleado->apellido,
            $empleado->cargo ? $empleado->cargo->nombre : 'N/A',
            $empleado->email ?? 'N/A',
            $empleado->telefono ?? 'N/A',
            $empleado->estado,
            $empleado->updated_at ? $empleado->updated_at->format('d/m/Y H:i') : 'N/A'
        ];
    }
}
