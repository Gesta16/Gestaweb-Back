<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PruebaNoTreponemicaRecienNacido;

class PruebaNoTreponemicaRecienNacidoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/pruebaNoTreponemicaRecienNacido.json'));
        foreach ($data->niveles_reactividad as $item){
            PruebaNoTreponemicaRecienNacido::create(array(
                'cod_treponemica' => $item->cod_treponemica,
                'nom_treponemica' => $item->nom_treponemica,
            ));
            }
    }
}
