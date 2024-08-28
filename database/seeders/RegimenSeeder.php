<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Regimen;

class RegimenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/regimen.json'));
        foreach ($data as $item){
            Regimen::create(array(
                'cod_regimen' => $item->cod_regimen,
                'nom_regimen' => $item->nom_regimen
            ));
            }   
}
}