<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hemoclasificacion;

class HemoclasificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/hemoclasificacion.json'));
        foreach ($data->tipos_sanguineos as $item){
            Hemoclasificacion::create(array(
                'cod_hemoclasifi' => $item->cod_hemoclasifi,
                'tip_hemoclasificacion' => $item->tip_hemoclasificacion,
            ));
            }
    }
}
