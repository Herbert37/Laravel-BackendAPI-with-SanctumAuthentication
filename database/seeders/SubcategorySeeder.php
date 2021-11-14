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
            'image' => 'subcategory-a1',
            'category_id' => $category->id
        ]);

        DB::table('subcategories')->insert([
            'name' => 'Subcategory A2',
            'image' => 'subcategory-a2',
            'category_id' => $category->id
        ]);
    }
}
