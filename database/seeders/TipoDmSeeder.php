<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDm;

class TipoDmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tipoDm.json'));
        foreach ($data->tipos_diabetes as $item){
            TipoDm::create(array(
                'cod_dm' => $item->cod_dm,
                'tip_dm' => $item->tip_dm,
            ));
            }
    }
}
