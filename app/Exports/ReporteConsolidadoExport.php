<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class ReporteConsolidadoExport implements FromCollection, WithHeadings
{
    protected $datos;
    protected $titulo;

    public function __construct($datos, $titulo = 'Reporte Consolidado')
    {
        $this->datos = $datos;
        $this->titulo = $titulo;
    }

    public function collection()
    {
        return $this->datos;
    }

    public function headings(): array
    {
        if ($this->datos->isEmpty()) {
            return [];
        }

        // Obtener las claves del primer elemento como encabezados
        return array_keys($this->datos->first()->toArray());
    }
}
