<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Region;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $region = Region::first();
        DB::table('users')->insert([
            'first_name' => 'Paque',
            'last_name' => 'Test',
            'email' => 'user_paque@gmail.com',
            'phone' => '63711212',
            'password' => Hash::make('password'),
            'region_id' => $region->id
        ]);
    }
}
