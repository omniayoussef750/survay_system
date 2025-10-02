<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class regionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('regions')->truncate();
        
        $regions = [
            'Cairo' => [
                'Shubra',
                'El-Zawiya al-Hamra',
                'Hadayek al-Kobba',
                'Rod al-Farg',
                'Al-Sharabiya',
                'Al-Sahel',
                'Al-Zaytoun',
                'Al-Amiriya',
                'Misr al-Gadidah',
                'Al-Nozha',
                'Nasr City East',
                'Nasr City West',
                'Al-Salam 1',
                'Al-Salam 2',
                'Al-Matariya',
                'Al-Marg',
                'New Cairo',
                'Al-Shorouk',
                'Badr',
                '15th May City',
                'New Administrative Capital',
                'Dar El Salam',
                'Al-Basatin',
                'Al-Tebin',
                'Al-Maadi',
                'Al-Mokattam',
                'Helwan',
                'Al-Ma’sara',
                'Al-Khalifa',
                'Old Cairo',
                'Al-Darb al-Ahmar',
                'Al-Gamaliya',
                'Al-Hussein',
                'Boulaq',
                'Abdeen',
                'Al-Azbakiya',
                'Al-Muski',
                'Bab El-Shaaria',
                'Wast El-Qahira',
                'Gharb El-Qahira',
                'Manshiyet Nasser',
                'El-Waily',
            ],
           'Alexandria' => [
                'El Dekhela',
                '1st El Amreya',
                '2nd El Amreya',
                'El Atareen',
                'El Gomrok',
                'El Labban',
                'El Manshiyya',
                '1st El Montaza',
                '2nd El Montaza',
                '1st El Raml',
                '2nd El Raml',
                'North Coast',
                'Bab Shar’',
                'Borg El Arab',
                'Karmouz',
                'New Borg El Arab',
                'Mina El Basal',
                'Moharam Bek',
                'Sidi Gaber',
            ],
            'Giza' => [
                'Dokki',
                'Mohandessin',
                '6th of October',
                'Sheikh Zayed',
            ],
            'Luxor' => [
                'Luxor City',
                'Armant',
                'Esna',
            ],
            'Aswan' => [
                'Aswan City',
                'Kom Ombo',
                'Edfu',
            ],
            'Gharbia' => [
                'El Mahalla El Kubra', 
                'El Sunta',
                'Basyoun',
                'Kafr El Zayat',
                'Kotoor',
                'Samanoud',
                'Tanta',
                'Zefta',
            ],
            'Dakahlia' => [
                // Example few
                'Ajā',
                'Al-Jamāliyah',
                'Al-Manṣūrah',
                'Al-Manzilah',
                'El Senbellawein',
                'Bani Ubayd',
                'Bilqās',
                'Dikirnis',
                'Gamasa',
                'Mahallet Damanah',
                'Minyat an-Naṣr',
                'Mīt Ghamr',
                'Mīt Salsīl',
                'Nabarūh',
                'Shirbīn',
                'Ṭalkhā',
                'Timay al-Imdīd',
            ],'Sohag' => [
                'Akhmim',
                'Al Balyana',
                'El Kawthar',
                'El Maragha',
                'El Munsha',
                'Aserat',
                'Dar El Salam',
                'Girga',
                'Juhaynah West',
                'New Akhmim',
                'New Sohag',
                'Saqultah',
                'Sohag',
                'Sohag 1',
                'Sohag 2',
                'Tahta',
                'Tima',
            ],
             'Qena' => [
                'Abu Tesht',
                'Dishna',
                'El Waqf',
                'Farshut',
                'Nag Hammadi',
                'Naqada',
                'New Qena',
                'Qena',
                'Qena (Markaz)',
                'Qift',
                'Qus',
            ],
            'Asyut' => [
                'Abnub',
                'Abu Tig',
                'El Badari',
                'El Fateh',
                'El Ghanayem',
                'El Qusiya',
                'Asyut',
                'Asyut 1',
                'Asyut 2',
                'Dairut',
                'New Asyut',
                'Manfalut',
                'Sahel Selim',
                'Sidfa',
            ],
        ];

        foreach ($regions as $govName => $regionList) {
            $governorate = DB::table('governorates')->where('name', $govName)->first();

            if ($governorate) {
                foreach ($regionList as $region) {
                    DB::table('regions')->insert([
                        'governorate_id' => $governorate->id,
                        'name' => $region,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
    }

