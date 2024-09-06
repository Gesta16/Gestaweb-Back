<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PruebaNoTreponemicaRPR;


class PruebaNoTreponemicaRPRSeeder extends Seeder
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
            PruebaNoTreponemicaRPR::create(array(
                'cod_rpr' => $item->cod_vdrl,
                'num_rpr' => $item->num_vdrl,
            ));
            }
    }
}
