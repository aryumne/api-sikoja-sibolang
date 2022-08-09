<?php

namespace Database\Seeders;

use App\Models\Instance;
use Illuminate\Database\Seeder;

class InstanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Instance::create([
            'instance' => 'Dinas PUPR Provinsi Papua Barat'
        ]);
        Instance::create([
            'instance' => 'Dinas PUPR Kabupaten Manokwari'
        ]);
        Instance::create([
            'instance' => 'BWS Papua Barat'
        ]);
        Instance::create([
            'instance' => 'Badan BPBD Kabupaten Manokwari'
        ]);
        Instance::create([
            'instance' => 'Dinas Sosial Kabupaten Manokwari'
        ]);
        Instance::create([
            'instance' => 'Balai Peningkatan Jalan Nasional (BPJN) Provinsi Papua Barat'
        ]);
    }
}
