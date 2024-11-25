<?php

namespace App\Exports;

use App\Models\Usuario;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReporteExport implements FromCollection
{
    protected $resultados;

    public function __construct($resultados)
    {
        $this->resultados = $resultados;
    }

    public function collection()
    {
        return collect($this->resultados);
    }
}
