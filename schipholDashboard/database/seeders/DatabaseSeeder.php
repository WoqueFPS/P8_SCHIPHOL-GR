<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        AirlineSeeder::class,
        FlightSeeder::class,
        GateSeeder::class,
        RoleSeeder::class,
        StaffTestSeeder::class,
        DirectorBroadcastSeeder::class,
        ]);

        User::updateOrCreate([       
            'email' => 'test@example.com'],
            [
            'name' => 'Test User',
            'password' => bcrypt('password'),
        ]);
    }
}
