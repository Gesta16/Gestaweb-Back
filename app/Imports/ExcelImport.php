<?php

namespace App\Imports;

use App\Models\Usuario;
use App\Models\Ips;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExcelImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Buscar el ID del rol basado en el tipo de usuario
        $rolName = $row['EPS DE AFILIACIÓN'] ?? 'NUEVA EPS'; 
        $rol = Ips::where('nom_ips', $rolName)->first();

        if (!$rol) {
            \Log::warning("El rol '{$rolName}' no existe. Fila: ", $row);
            return null; // Ignora esta fila
        }


        // Crea o actualiza el usuario basado en los datos de la fila
        return new Usuario([
            'cod_departamento' => $row['nombre'] ?? 1,
            'cod_municipio' => $row['nombre'] ?? 1,
            'cod_ips' => $rol->cod_ips ?? 1,

            'nom_usuario' => $row['nombre'] ?? 'No se encontró nada',
            'ape_usuario' => $row['apellido'] ?? 'No se encontró nada',
            'tel_usuario' => $row['telefono'] ?? 'No se encontró nada',
        ]);
    }
}
