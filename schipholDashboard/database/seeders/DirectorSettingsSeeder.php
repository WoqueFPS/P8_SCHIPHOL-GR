<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DirectorSetting;
use App\Models\TeamAllocation;

class DirectorSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DirectorSetting::setValue('noodmodus', 'false');
        DirectorSetting::setValue('vluchtprioriteit', 'intercontinentaal');
        
        $teams = ['oost' => 4, 'west' => 3, 'cargo' => 2];
        foreach ($teams as $team => $count) {
            TeamAllocation::updateOrCreate(
                ['team_name' => $team],
                ['coordinator_count' => $count]
            );
        }
    }
}
