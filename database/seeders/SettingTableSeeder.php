<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->insert([
            'id_setting' => 1,
            'name_company' => 'Apotek',
            'address' => 'Jl. Boulevard Raya',
            'phone' => '021 2345 6789',
            'type_nota' => 1, // nota kecil
            'discount' => 5,
            'tax' => 11,
            'path_logo' => '/images/logo pos apotek.png',
            'path_card_member' => '/images/wood bg.png',
        ]);
    }
}
