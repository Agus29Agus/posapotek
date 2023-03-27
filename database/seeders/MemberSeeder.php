<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 1;
        $data = [];
        for ($i=0; $i < $count; $i++) { 
            $data[] = [
                'code_member'=>'member-'.$i+1,
                'name'=>'Ferry Agustius',
                'address'=>'Jakarta Barat',
                'phone'=>'021 3456 789'
            ];
        }
        Member::insert($data);
    }
}