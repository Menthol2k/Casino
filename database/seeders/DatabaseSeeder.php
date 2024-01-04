<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'octavian',
            'email' => 'octavian@twm.ro',
            'password' => Hash::make('twm2022'),
            'balance' => 1000,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Marian',
            'email' => 'marian@gmail.ro',
            'password' => Hash::make('123'),
            'balance' => 1000,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Adi',
            'email' => 'adi@gmail.ro',  
            'password' => Hash::make('456'),
            'balance' => 1000,
        ]);

    \App\Models\User::factory()->create([
            'name' => 'andrei',
            'email' => 'andrei@gmail.ro',
            'password' => Hash::make('789'),
            'balance' => 1000,
        ]);
    }
}
