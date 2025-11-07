<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Address::create([
            'user_id' => 1,
            'user_type' => 'App\\Models\\User',
            'village' => 'Mirpur',
            'road_no' => '10',
            'house_no' => '25B',
            'union' => 'Kallyanpur',
            'post_office' => 'Mirpur-2',
            'sub_district' => 'Mirpur',
            'district' => 'Dhaka',
            'division' => 'Dhaka',
        ]);

        Address::create([
            'user_id' => 1,
            'user_type' => 'App\\Models\\Admin',
            'village' => 'Banani',
            'road_no' => '12',
            'house_no' => '45A',
            'union' => 'Banani Model',
            'post_office' => 'Banani',
            'sub_district' => 'Gulshan',
            'district' => 'Dhaka',
            'division' => 'Dhaka',
        ]);

    }
}
