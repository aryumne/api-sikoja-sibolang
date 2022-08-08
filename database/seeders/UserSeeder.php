<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'IT CENTER UNIPA',
            'username' => 'devtikpuskom',
            'password' => Hash::make('unipajaya'),
            'role_id' => 1,
            'instance_id' => 1,
            'email' => 'dev.tik@unipa.ac.id',
            'hp' => null,
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Admin SIKOJA-SIBOLANG',
            'username' => 'admin',
            'password' => Hash::make('sikoja_sibolang'),
            'role_id' => 2,
            'instance_id' => 2,
            'email' => 'admin@gmail.com',
            'hp' => null,
            'email_verified_at' => now()
        ]);
    }
}
