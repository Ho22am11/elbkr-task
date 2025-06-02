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
        User::create([
            'frist_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('1236542'), 
            'phone' => '01000000000',
            'role' => 'admin',
        ]);

        User::create([
            'frist_name' => 'man',
            'last_name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('12121'),
            'phone' => '01100000000',
            'role' => 'user',
        ]);
    }
}
