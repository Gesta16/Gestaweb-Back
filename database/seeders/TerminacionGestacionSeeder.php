<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TerminacionGestacion;

class TerminacionGestacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/terminacionGestacion.json'));
        foreach ($data->terminacion_gestacion as $item){
            TerminacionGestacion::create(array(
                'cod_terminacion' => $item->cod_terminacion,
                'nom_terminacion' => $item->nom_terminacion,
            ));
            }
    }
}
