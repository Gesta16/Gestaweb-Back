<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tipoDocumento.json'));
        foreach ($data as $item){
            TipoDocumento::create(array(
                'cod_documento' => $item->cod_documento,
                'nom_documento' => $item->nom_documento,
            ));
            }
    }
}
