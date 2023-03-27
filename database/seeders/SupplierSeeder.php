<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 1;
        $data = [];
        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'name' => 'Kimia Farma',
                'address' => 'Tangerang Raya',
                'phone' => '021 3456 789'
            ];
        }
        Supplier::insert($data);
    }
}