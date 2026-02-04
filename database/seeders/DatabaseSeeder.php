<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $storekeeperRole = Role::firstOrCreate(['name' => 'storekeeper']);
        $managerRole = Role::firstOrCreate(['name' => 'manager']);

        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin2@example.com'],
            [
                'name' => 'Admin User 2',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'storekeeper@example.com'],
            [
                'name' => 'Storekeeper User',
                'password' => Hash::make('password'),
                'role_id' => $storekeeperRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'storekeeper2@example.com'],
            [
                'name' => 'Storekeeper User 2',
                'password' => Hash::make('password'),
                'role_id' => $storekeeperRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'manager@example.com'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'role_id' => $managerRole->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'manager2@example.com'],
            [
                'name' => 'Manager User 2',
                'password' => Hash::make('password'),
                'role_id' => $managerRole->id,
            ]
        );
    }
}

