<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Subcategory;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategory = Subcategory::first();
        DB::table('specialties')->insert([
            'name' => 'Specialty A1',
            'image' => 'specialty-a1.png',
            'min_price_range' => '50',
            'max_price_range' => '70',
            'subcategory_id' => $subcategory->id
        ]);

        DB::table('specialties')->insert([
            'name' => 'Specialty A2',
            'image' => 'specialty-a2.png',
            'min_price_range' => '60',
            'max_price_range' => '80',
            'subcategory_id' => $subcategory->id
        ]);
    }
}
