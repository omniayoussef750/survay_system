<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Section;
use Illuminate\Support\Facades\DB;

class SectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('sections')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

         $sections = [
            'Demographics',
            'Social Status',
            'Education',
            'Career',
            'E-Commerce',
            'Technology',

            
           
            // add all the sections you use
        ];
        foreach ($sections as $section) {
            Section::create(['title' => $section]);
        }
    }
}
