<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@klinik.com',
            'role' => 'admin',
            'password' => Hash::make('anjay'),
        ]);
    }
}