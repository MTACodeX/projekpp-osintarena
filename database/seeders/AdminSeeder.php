<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@osint.local'],
            [
                'username' => 'admin',
                'name' => 'admin',
                'password' => Hash::make('mantaganteng'),
                'role' => 'admin',
            ]
        );

        Team::firstOrCreate(
            ['user_id' => $admin->id],
            [
                'team_name' => 'Admin Team',
                'team_name_type' => 'custom',
                'score' => 0,
            ]
        );
    }
}