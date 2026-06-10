<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StaffTestSeeder extends Seeder
{
    public function run(): void
    {
        Staff::create([
            'name' => 'Test Coordinator',
            'email' => 'coordinator@schiphol.nl',
            'employee_id' => 'AMS-001',
            'password' => Hash::make('password123'),
            'role' => 'coordinator',
        ]);

        Staff::create([
            'name' => 'Test Director',
            'email' => 'director@schiphol.nl',
            'employee_id' => 'AMS-002',
            'password' => Hash::make('password123'),
            'role' => 'directeur',
        ]);
    }
}