<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NumeroControles;

class NumeroControlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/numeroControles.json'));
        foreach ($data->numero_controles as $item){
            NumeroControles::create(array(
                'cod_controles' => $item->cod_controles,
                'num_control' => $item->num_control,
            ));
            }
    }
}
