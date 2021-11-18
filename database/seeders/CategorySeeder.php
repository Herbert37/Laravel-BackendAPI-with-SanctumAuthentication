<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Categoria A',
            'image' => 'https://www.nicepng.com/png/full/815-8154404_paisaje-de-pradera-animado.png',
        ]);

        DB::table('categories')->insert([
            'name' => 'Categoria B',
            'image' => 'https://www.nicepng.com/png/full/815-8154404_paisaje-de-pradera-animado.png',
        ]);
    }
}
