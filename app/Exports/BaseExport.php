<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;
use Carbon\Carbon;

abstract class BaseExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, WithProperties, ShouldAutoSize
{
    protected $datos;
    protected $titulo;
    protected $headings = [];
    protected $columnas;

    public function __construct($datos, $titulo = null)
    {
        $this->datos = $datos;
        $this->titulo = $titulo;
        $this->columnas = $this->definirColumnas();
    }

    public function collection()
    {
        return new Collection($this->datos->map(fn($item) => $this->map($item)));
    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function styles(Worksheet $sheet)
    {
        // Estilo para el encabezado
        $sheet->getStyle(1)->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F46E5'], // Color Indigo-600
            ],
        ]);

        // Alternar colores de filas
        $lastRow = $sheet->getHighestRow();
        for ($i = 2; $i <= $lastRow; $i++) {
            if ($i % 2 == 0) {
                $sheet->getStyle($i)->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F9FAFB'], // Color Gray-50
                    ],
                ]);
            }
        }

        // Bordes para todas las celdas
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . $lastRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'E5E7EB'], // Color Gray-200
                ],
            ],
        ]);

        return [];
    }

    public function title(): string
    {
        return $this->titulo ?? 'Reporte';
    }

    public function properties(): array
    {
        return [
            'creator'        => config('app.name'),
            'lastModifiedBy' => config('app.name'),
            'title'         => $this->title(),
            'description'   => 'Reporte generado el ' . now()->format('d/m/Y H:i:s'),
            'subject'       => $this->title(),
            'keywords'      => 'reportes,excel,laravel',
            'category'      => 'Reportes',
            'manager'       => 'Sistema de Inventario',
            'company'       => config('app.name'),
        ];
    }

    protected function formatearFecha($fecha)
    {
        if (!$fecha) return 'N/A';
        return $fecha instanceof Carbon ? $fecha->format('d/m/Y H:i:s') : $fecha;
    }

    protected function formatearBooleano($valor)
    {
        if (is_bool($valor)) {
            return $valor ? 'Sí' : 'No';
        }
        return $valor ?? 'N/A';
    }

    protected function formatearEstado($estado)
    {
        return ucfirst(strtolower($estado ?? 'N/A'));
    }

    abstract protected function definirColumnas(): array;

    abstract public function map($item): array;
}
