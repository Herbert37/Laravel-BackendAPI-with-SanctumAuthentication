<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regions')->insert([
            'name' => 'El salvador',
            'slug' => 'el-salvador',
        ]);

        DB::table('regions')->insert([
            'name' => 'Guatemala',
            'slug' => 'guatemala',
        ]);
    }
}
