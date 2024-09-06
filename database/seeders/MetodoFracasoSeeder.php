<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetodoFracaso;

class MetodoFracasoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/metodoFracaso.json'));
        foreach ($data->metodos_anticonceptivos as $item){
            MetodoFracaso::create(array(
                'cod_fracaso' => $item->cod_fracaso,
                'nom_metodo' => $item->nom_metodo,
            ));
            }
    }
}
