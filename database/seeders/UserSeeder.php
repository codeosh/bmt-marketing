<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "user",
            'email' => "user@email.com",
            'role' => "user",
            'password' => bcrypt('password'),
        ]);
        User::create([
            'name' => "admin",
            'email' => "admin@email.com",
            'role' => "admin",
            'password' => bcrypt('password'),
        ]);
    }
}
