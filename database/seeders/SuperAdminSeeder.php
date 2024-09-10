<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuperAdmin;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/superadmin.json'));
        foreach ($data as $item){
            SuperAdmin::create(array(
                'id_superadmin' => $item->id_superadmin,
                'nom_superadmin' => $item->nom_superadmin,
                'ape_superadmin' => $item->ape_superadmin,
                'cod_documento' => $item->cod_documento,
                'documento_superadmin' => $item->documento_superadmin,
                'email_superadmin' => $item->email_superadmin,
                'tel_superadmin' => $item->tel_superadmin,
            ));
            }
    }
}
