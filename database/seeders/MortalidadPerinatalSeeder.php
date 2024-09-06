<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MortalidadPerinatal;

class MortalidadPerinatalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/mortalidadPerinatal.json'));
        foreach ($data->clasificacion_momento_muerte as $item){
            MortalidadPerinatal::create(array(
                'cod_mortalidad' => $item->cod_mortalidad,
                'cla_muerte' => $item->cla_muerte,
            ));
            }
    }
}
