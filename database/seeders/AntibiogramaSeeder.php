<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Antibiograma;

class AntibiogramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/antibiograma.json'));
        foreach ($data->sensibilidad_antibioticos as $item){
            Antibiograma::create(array(
                'cod_antibiograma' => $item->cod_antibiograma,
                'nom_antibiograma' => $item->nom_antibiograma,
            ));
            }
    }
}
