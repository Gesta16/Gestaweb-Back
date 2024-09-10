<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/json/users.json'));
        foreach ($data as $item){
            User::create(array(
                'id' => $item->id,
                'name' => $item->name,
                'documento' => $item->documento,
                'password' => bcrypt($item->password),
                'userable_id' => $item->userable_id,
                'userable_type' => $item->userable_type,
                'rol_id' => $item->rol_id,

            ));
            }
    }
}
