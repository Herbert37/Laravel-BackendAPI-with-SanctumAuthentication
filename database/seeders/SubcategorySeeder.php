<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Category;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::first();
        DB::table('subcategories')->insert([
            'name' => 'Subcategory A1',
            'image' => 'https://www.nicepng.com/png/full/815-8154404_paisaje-de-pradera-animado.png',
            'category_id' => $category->id
        ]);

        DB::table('subcategories')->insert([
            'name' => 'Subcategory A2',
            'image' => 'https://www.nicepng.com/png/full/815-8154404_paisaje-de-pradera-animado.png',
            'category_id' => $category->id
        ]);
    }
}
