<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SoftphonesExport extends BaseExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $datos;
    protected $columnas;

    public function __construct($datos, $titulo = null)
    {
        parent::__construct($datos, $titulo ?? 'Reporte de Softphones');
        $this->datos = $datos;
        $this->columnas = $this->definirColumnas();
    }

    public function collection()
    {
        return $this->datos;
    }

    public function headings(): array
    {
        return array_values($this->columnas);
    }

    public function map($softphone): array
    {
        return [
            $softphone->usuario ?? 'N/A',
            $softphone->dispositivo ?? 'N/A',
            $softphone->version ?? 'N/A',
            $softphone->fabricante ?? 'N/A',
            $softphone->licencia ?? 'N/A',
            $this->formatearEstado($softphone->estado),
            optional($softphone->empleado)->nombre ?? 'No asignado',
            optional(optional($softphone->empleado)->ubicacion)->nombre ?? 'N/A',
            optional(optional(optional($softphone->empleado)->ubicacion)->sede)->nombre ?? 'N/A',
            $this->formatearFecha($softphone->created_at),
            $this->formatearFecha($softphone->updated_at)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    protected function definirColumnas(): array
    {
        return [
            'usuario' => 'Usuario',
            'dispositivo' => 'Dispositivo',
            'version' => 'Versión',
            'fabricante' => 'Fabricante',
            'licencia' => 'Licencia',
            'estado' => 'Estado',
            'empleado' => 'Empleado Asignado',
            'ubicacion' => 'Ubicación',
            'sede' => 'Sede',
            'created_at' => 'Fecha de Creación',
            'updated_at' => 'Última Actualización'
        ];
    }

    protected function formatearEstado($estado)
    {
        // Implementa la lógica para formatear el estado según tus necesidades
        return $estado;
    }

    protected function formatearFecha($fecha)
    {
        if ($fecha) {
            return $fecha->format('d/m/Y H:i:s');
        }
        return '';
    }
}
