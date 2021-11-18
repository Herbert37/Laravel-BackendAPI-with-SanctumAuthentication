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
            'image' => 'https://picsum.photos/200',
            'min_price_range' => '50',
            'max_price_range' => '70',
            'type' => 'popular',
            'subcategory_id' => $subcategory->id
        ]);

        DB::table('specialties')->insert([
            'name' => 'Specialty A2',
            'image' => 'https://picsum.photos/200',
            'min_price_range' => '60',
            'max_price_range' => '80',
            'type' => 'popular',
            'subcategory_id' => $subcategory->id
        ]);

        DB::table('specialties')->insert([
            'name' => 'Specialty A3',
            'image' => 'https://picsum.photos/200',
            'min_price_range' => '50',
            'max_price_range' => '70',
            'type' => 'popular',
            'subcategory_id' => $subcategory->id
        ]);

        DB::table('specialties')->insert([
            'name' => 'Specialty A4',
            'image' => 'https://picsum.photos/200',
            'min_price_range' => '60',
            'max_price_range' => '80',
            'type' => 'recommended',
            'subcategory_id' => $subcategory->id
        ]);

        DB::table('specialties')->insert([
            'name' => 'Specialty A5',
            'image' => 'https://picsum.photos/200',
            'min_price_range' => '50',
            'max_price_range' => '70',
            'type' => 'recommended',
            'subcategory_id' => $subcategory->id
        ]);

        DB::table('specialties')->insert([
            'name' => 'Specialty A6',
            'image' => 'https://picsum.photos/200',
            'min_price_range' => '60',
            'max_price_range' => '80',
            'type' => 'recommended',
            'subcategory_id' => $subcategory->id
        ]);

        DB::table('specialties')->insert([
            'name' => 'Specialty A7',
            'image' => 'https://picsum.photos/200',
            'min_price_range' => '50',
            'max_price_range' => '70',
            'subcategory_id' => $subcategory->id
        ]);

        DB::table('specialties')->insert([
            'name' => 'Specialty A8',
            'image' => 'https://picsum.photos/200',
            'min_price_range' => '60',
            'max_price_range' => '80',
            'subcategory_id' => $subcategory->id
        ]);

        DB::table('specialties')->insert([
            'name' => 'Specialty A9',
            'image' => 'https://picsum.photos/200',
            'min_price_range' => '50',
            'max_price_range' => '70',
            'subcategory_id' => $subcategory->id
        ]);

        DB::table('specialties')->insert([
            'name' => 'Specialty A10',
            'image' => 'https://picsum.photos/200',
            'min_price_range' => '60',
            'max_price_range' => '80',
            'subcategory_id' => $subcategory->id
        ]);
    }
}
