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
            'name' => 'James Woria',
            'username' => 'james873',
            'password' => Hash::make('james873'),
            'role_id' => 2,
            'instance_id' => 2,
            'email' => 'jameswr873@gmail.com',
            'hp' => '081344708219',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Istirja P.Siregar',
            'username' => 'ucokpu',
            'password' => Hash::make('ucokpu'),
            'role_id' => 2,
            'instance_id' => 2,
            'email' => 'ucok.pu.75@gmail.com',
            'hp' => '081343493839',
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Endah S.',
            'username' => 'endah',
            'password' => Hash::make('endah'),
            'role_id' => 2,
            'instance_id' => 2,
            'email' => 'endahsidey@gmail.com',
            'hp' => '08114858097',
            'email_verified_at' => now()
        ]);
    }
}
