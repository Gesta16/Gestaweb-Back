<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetodoAnticonceptivo;

class MetodoAnticonceptivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/metodoAnticonceptivo.json'));
        foreach ($data->metodos_anticonceptivos as $item){
            MetodoAnticonceptivo::create(array(
                'cod_metodo' => $item->cod_metodo,
                'nom_metodo' => $item->nom_metodo,
            ));
            }
    }
}
