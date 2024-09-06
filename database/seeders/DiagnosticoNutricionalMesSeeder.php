<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiagnosticoNutricionalMes;

class DiagnosticoNutricionalMesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/diagnosticoNutricionalMes.json'));
        foreach ($data->estado_nutricional_edad_gestacional as $item){
            DiagnosticoNutricionalMes::create(array(
                'cod_diagnostico' => $item->cod_diagnostico,
                'nom_diagnostico' => $item->nom_diagnostico,
            ));
            }
    }
}
