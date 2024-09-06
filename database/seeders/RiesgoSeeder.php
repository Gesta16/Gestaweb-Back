<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Riesgo;

class RiesgoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/riesgo.json'));
        foreach ($data->niveles_riesgo as $item){
            Riesgo::create(array(
                'cod_riesgo' => $item->cod_riesgo,
                'nom_riesgo' => $item->nom_riesgo,
            ));
            }
    }
}
