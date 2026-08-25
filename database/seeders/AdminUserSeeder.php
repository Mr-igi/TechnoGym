<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Creates the default admin account plus one regular member account
     * so the app can be explored right after a fresh install.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@technogym.test'],
            [
                'name'     => 'Admin',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        User::updateOrCreate(
            ['email' => 'member@technogym.test'],
            [
                'name'     => 'Demo Clan',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );
    }
}
