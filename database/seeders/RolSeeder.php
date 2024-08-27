<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/tb_rol.json'));
        foreach ($data as $item){
            Rol::create(array(
                'nombre_rol' => $item->rol,
            ));
            }
    }
}
