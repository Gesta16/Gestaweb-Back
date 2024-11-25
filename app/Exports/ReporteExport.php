<?php

namespace App\Exports;

use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteExport implements FromArray, WithHeadings
{
    protected $resultados;
    protected $encabezados;

    public function __construct($resultados, $encabezados)
    {
        $this->resultados = $resultados;
        $this->encabezados = $encabezados;
    }

    
    public function array(): array
    {
        return $this->resultados;
    }

    public function headings(): array
    {
        return $this->encabezados;
    }
}
