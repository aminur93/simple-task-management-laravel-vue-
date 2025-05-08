<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Create admin user
         User::create([
            'name' => 'admin',
            'email' => 'admin@example.com', 
            'phone' => '01772119941',
            'password' => Hash::make('password123')
        ]);

        // Create khan user
        User::create([
            'name' => 'khan',
            'email' => 'khan@example.com', 
            'phone' => '01772119942',
            'password' => Hash::make('password123')
        ]);
    }
}