<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class governoratesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = [
            'Cairo',
            'Alexandria',
            'Giza',
            'Qalyubia',
            'Port Said',
            'Suez',
            'Dakahlia',
            'Sharqia',
            'Gharbia',
            'Monufia',
            'Beheira',
            'Kafr El Sheikh',
            'Damietta',
            'Ismailia',
            'Faiyum',
            'Beni Suef',
            'Minya',
            'Asyut',
            'Sohag',
            'Qena',
            'Luxor',
            'Aswan',
            'Red Sea',
            'New Valley',
            'Matrouh',
            'North Sinai',
            'South Sinai',
        ];

        foreach ($governorates as $gov) {
            DB::table('governorates')->insert([
                'name' => $gov,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
    }

