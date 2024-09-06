<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NumSesionesCursoPaternidadMaternidad;

class NumSesionesCursoPaternidadMaternidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/numSesionesCurso.json'));
        foreach ($data->numero_sesiones as $item){
            NumSesionesCursoPaternidadMaternidad::create(array(
                'cod_sesiones' => $item->cod_sesiones,
                'num_sesiones' => $item->num_sesiones,
            ));
            }
    }
}
