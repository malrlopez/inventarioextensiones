<?php

namespace App\Traits;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

trait Exportable
{
    public function exportToFormat($data, $exportClass, $fileName, $format)
    {
        $export = new $exportClass($data);

        switch ($format) {
            case 'excel':
                return Excel::download($export, $fileName . '.xlsx');
            case 'csv':
                return Excel::download($export, $fileName . '.csv', \Maatwebsite\Excel\Excel::CSV);
            case 'pdf':
                $pdf = Pdf::loadView('exports.pdf', [
                    'data' => $data,
                    'headings' => $export->headings(),
                    'rows' => $data->map(function ($item) use ($export) {
                        return $export->map($item);
                    })
                ]);
                return $pdf->download($fileName . '.pdf');
            default:
                abort(404);
        }
    }
}
