<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormaMedicionEdadGestacional;

class FormaMedicionEdadGestacionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/formaMedicionEdadGestacional.json'));
        foreach ($data->forma_medicion_edad_gestacional as $item){
            FormaMedicionEdadGestacional::create(array(
                'cod_medicion' => $item->cod_medicion,
                'nom_forma' => $item->nom_forma,
            ));
            }
    }
}
