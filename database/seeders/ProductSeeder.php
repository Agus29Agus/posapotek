<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
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
                'code_product' => '000000'.$i+1,
                'id_category'=>(1),
                'name_product' => 'Trombopop',
                'brand'=>'Trombopop',
                'buy_price'=>'1000',
                'sell_price'=>'10000',
                'stock'=>100
            ];
        }
        Product::insert($data);
    }
}