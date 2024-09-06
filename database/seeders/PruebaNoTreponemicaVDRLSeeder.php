<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PruebaNoTreponemicaVDRL;

class PruebaNoTreponemicaVDRLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/pruebaNoTreponemicaVDRL.json'));
        foreach ($data->niveles_reactividad as $item){
            PruebaNoTreponemicaVDRL::create(array(
                'cod_vdrl' => $item->cod_vdrl,
                'num_vdrl' => $item->num_vdrl,
            ));
            }
    }
}
