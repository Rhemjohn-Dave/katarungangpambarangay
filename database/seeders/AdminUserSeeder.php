<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@barangay.com'],
            [
                'name'     => 'System Administrator',
                'email'    => 'admin@barangay.com',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        $this->command->info('Default admin account created: admin@barangay.com / password');
    }
}
