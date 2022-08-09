<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        District::create([
            'district' => 'Manokwari Barat'
        ]);
        District::create([
            'district' => 'Manokwari Selatan'
        ]);
        District::create([
            'district' => 'Manokwari Timur'
        ]);
        District::create([
            'district' => 'Manokwari Utara'
        ]);
        District::create([
            'district' => 'Masni'
        ]);
        District::create([
            'district' => 'Prafi'
        ]);
        District::create([
            'district' => 'Sidey'
        ]);
        District::create([
            'district' => 'Tanah Rubuh'
        ]);
        District::create([
            'district' => 'Warmare'
        ]);
    }
}
