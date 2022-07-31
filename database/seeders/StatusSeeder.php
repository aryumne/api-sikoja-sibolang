<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            "statuse" => "Laporan Diterima"
        ]);
        Status::create([
            "statuse" => "Laporan Didisposisikan"
        ]);
        Status::create([
            "statuse" => "Laporan Ditindaklanjuti"
        ]);
        Status::create([
            "statuse" => "Selesai"
        ]);
    }
}
