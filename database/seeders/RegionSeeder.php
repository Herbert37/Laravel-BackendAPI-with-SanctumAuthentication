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
            'image' => 'https://www.nicepng.com/png/full/815-8154404_paisaje-de-pradera-animado.png',
        ]);

        DB::table('regions')->insert([
            'name' => 'Guatemala',
            'slug' => 'guatemala',
            'image' => 'https://www.nicepng.com/png/full/815-8154404_paisaje-de-pradera-animado.png',
        ]);
    }
}
