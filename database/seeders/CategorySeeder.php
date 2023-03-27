<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name_category'=>"Obat Cair"],
            ['name_category'=>"Obat Tablet"],
            ['name_category'=>"Obat Kapsul"]
        ];
        Category::insert($data);
    }
}