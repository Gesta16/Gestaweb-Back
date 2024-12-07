<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EpsPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ips')->insert([
            [
                'cod_departamento' => 1,
                'cod_municipio' => 1,
                'cod_regimen' => 1,
                'nom_ips' => 'UT- FOSCAL - SAN ALONSO',
                'dir_ips' => 'direccion ut foscal',
                'tel_ips' => '3214105263',
                'email_ips' => 'foscal1@gmail.com',
                'nit_ips' => '1234567890',
            ],
            [
                'cod_departamento' => 2,
                'cod_municipio' => 2,
                'cod_regimen' => 2,
                'nom_ips' => 'UT- FOSCAL - SAN ALONSO2',
                'dir_ips' => 'direccion ut foscal 2',
                'tel_ips' => '32141052634',
                'email_ips' => 'foscal2@gmail.com',
                'nit_ips' => '12345678901',
            ],
            [
                'cod_departamento' => 3,
                'cod_municipio' => 3,
                'cod_regimen' => 1,
                'nom_ips' => 'UT- FOSCAL - SAN ALONSO3',
                'dir_ips' => 'direccion ut foscal 3',
                'tel_ips' => '32141052635',
                'email_ips' => 'foscal3@gmail.com',
                'nit_ips' => '12345678902',
            ],
            [
                'cod_departamento' => 4,
                'cod_municipio' => 4,
                'cod_regimen' => 2,
                'nom_ips' => 'UT- FOSCAL - SAN ALONSO4',
                'dir_ips' => 'direccion ut foscal 4',
                'tel_ips' => '32141052636',
                'email_ips' => 'foscal4@gmail.com',
                'nit_ips' => '12345678903',
            ],
            [
                'cod_departamento' => 5,
                'cod_municipio' => 5,
                'cod_regimen' => 1,
                'nom_ips' => 'UT- FOSCAL - SAN ALONSO5',
                'dir_ips' => 'direccion ut foscal 5',
                'tel_ips' => '32141052637',
                'email_ips' => 'foscal5@gmail.com',
                'nit_ips' => '12345678904',
            ],
        ]);
    }
}
