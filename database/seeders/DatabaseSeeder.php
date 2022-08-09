<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\StatusSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\DistrictSeeder;
use Database\Seeders\InstanceSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            StatusSeeder::class,
            RoleSeeder::class,
            CategorySeeder::class,
            UserSeeder::class,
            DistrictSeeder::class,
            InstanceSeeder::class
        ]);
    }
}
