<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Bureau Central (Top Level)
        User::create([
            'name' => 'Directeur Central',
            'email' => 'central@tansiq.ma',
            'password' => Hash::make('password123'),
            'role' => 'bureau_central',
        ]);

        // 2. National Coordinator
        User::create([
            'name' => 'Coordinateur National',
            'email' => 'national@tansiq.ma',
            'password' => Hash::make('password123'),
            'role' => 'national',
        ]);

        // 3. Regional Coordinator
        User::create([
            'name' => 'Responsable Régional',
            'email' => 'regional@tansiq.ma',
            'password' => Hash::make('password123'),
            'role' => 'regional',
        ]);

        // 4. Territorial Worker (Bottom Level)
        User::create([
            'name' => 'Agent Territorial',
            'email' => 'territorial@tansiq.ma',
            'password' => Hash::make('password123'),
            'role' => 'territorial',
        ]);
    }
}