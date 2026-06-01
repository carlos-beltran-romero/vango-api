<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@vango.com'],
            [
                'name' => 'Admin VanGo',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@vango.com'],
            [
                'name' => 'Usuario VanGo',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );
    }
}