<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'manager@example.com'
        ], [
            'name' => 'Manager',
            'password' => Hash::make('password123'),
            'role' => 'manager',
        ]);
    }
}
