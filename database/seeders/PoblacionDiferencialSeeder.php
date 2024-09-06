<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PoblacionDiferencial;

class PoblacionDiferencialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/poblacionDiferencial.json'));
        foreach ($data->poblacion_diferencial as $item){
            PoblacionDiferencial::create(array(
                'cod_poblacion' => $item->cod_poblacion,
                'nom_poblacion' => $item->nom_poblacion,
            ));
            }
    }
}
