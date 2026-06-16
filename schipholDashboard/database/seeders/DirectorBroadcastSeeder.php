<?php

namespace Database\Seeders;

use App\Models\DirectorBroadcast;
use Illuminate\Database\Seeder;

class DirectorBroadcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
        {
            DirectorBroadcast::create([
                'message'    => 'Let op: Vanwege onderhoud aan de landingsbanen kunnen vluchten in de ochtend vertraging oplopen.',
                'sent_by'    => 1,
                'is_active'  => true,
                'expires_at' => now()->addDays(2),
            ]);
        }
}
