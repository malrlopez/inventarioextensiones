<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExtensionesExport extends BaseExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $datos;
    protected $campos;
    protected $encabezados;

    public function __construct($datos, $titulo = null, $campos = null, $encabezados = null)
    {
        parent::__construct($datos, $titulo ?? 'Reporte de Extensiones');
        $this->datos = $datos;
        $this->campos = $campos ?: [];
        $this->encabezados = $encabezados ?: $this->getDefaultHeadings();
    }

    public function collection()
    {
        return $this->datos;
    }

    public function headings(): array
    {
        return $this->encabezados;
    }

    protected function getDefaultHeadings(): array
    {
        return [
            'ID',
            'Número',
            'Tecnología',
            'Estado',
            'Asignado a',
            'Sede',
            'Ubicación',
            'Fecha de Creación',
            'Última Actualización'
        ];
    }

    public function map($extension): array
    {
        // Si se proporcionaron campos personalizados, usarlos para el mapeo
        if (is_array($this->campos) && !empty($this->campos)) {
            $resultado = [];
            foreach ($this->campos as $campo) {
                $resultado[] = $this->obtenerValorCampo($extension, $campo);
            }
            return $resultado;
        }
        
        // Si no hay campos personalizados, usar el mapeo predeterminado
        return [
            $extension->id ?? '',
            $extension->numero ?? '',
            $extension->tecnologia ?? '',
            $extension->estado ?? '',
            optional($extension->usuario)->name ?? 'No asignado',
            optional(optional($extension->ubicacion)->sede)->nombre ?? 'N/A',
            optional($extension->ubicacion)->nombre ?? 'N/A',
            $extension->created_at ? $extension->created_at->format('d/m/Y H:i:s') : '',
            $extension->updated_at ? $extension->updated_at->format('d/m/Y H:i:s') : ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
    
    protected function obtenerValorCampo($objeto, $campo)
    {
        // Manejar campos especiales con relaciones
        switch ($campo) {
            case 'usuario':
            case 'asignado_a':
                return optional($objeto->usuario)->name ?? 'No asignado';
            case 'ubicacion':
                return optional($objeto->ubicacion)->nombre ?? 'N/A';
            case 'sede':
                return optional(optional($objeto->ubicacion)->sede)->nombre ?? 'N/A';
            case 'estado':
                return $objeto->estado ?? '';
            case 'created_at':
            case 'updated_at':
            case 'fecha_creacion':
            case 'ultima_actualizacion':
                $fechaCampo = $campo;
                if ($campo === 'fecha_creacion') $fechaCampo = 'created_at';
                if ($campo === 'ultima_actualizacion') $fechaCampo = 'updated_at';
                return $objeto->{$fechaCampo} ? $objeto->{$fechaCampo}->format('d/m/Y H:i:s') : '';
            default:
                return $objeto->{$campo} ?? 'N/A';
        }
    }
}
