<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Biologico;

class BiologicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/biologico.json'));
        foreach ($data->vacunas_covid as $item){
            Biologico::create(array(
                'cod_biologico' => $item->cod_biologico,
                'nom_biologico' => $item->nom_biologico,
            ));
            }
    }
}
