<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        DB::table('locations')->insert([
            'reference' => 'Casa',
            'latitude' => '13.676851',
            'longitude' => '-89.238675',
            'is_current' => true,
            'user_id' => $user->id
        ]);

        DB::table('locations')->insert([
            'reference' => 'Trabajo',
            'latitude' => '13.729213',
            'longitude' => '-89.201437',
            'is_current' => false,
            'user_id' => $user->id
        ]);
    }
}
