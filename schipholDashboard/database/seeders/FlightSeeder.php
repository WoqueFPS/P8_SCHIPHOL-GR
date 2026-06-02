<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flight;

class FlightSeeder extends Seeder
{
    public function run(): void
    {
        $flights = [
            // aankomend
            ['flight_number'=>'KL1234','airline'=>'KLM',       'airline_code'=>'KL','origin'=>'Londen',   'destination'=>'Amsterdam','gate'=>'B14','terminal'=>'B','type'=>'arriving','status'=>'op-tijd',   'scheduled_time'=>'14:30'],
            ['flight_number'=>'AF5678','airline'=>'Air France', 'airline_code'=>'AF','origin'=>'Parijs',   'destination'=>'Amsterdam','gate'=>'D22','terminal'=>'D','type'=>'arriving','status'=>'vertraging','scheduled_time'=>'15:45','delay_minutes'=>15],
            ['flight_number'=>'DL9012','airline'=>'Delta',      'airline_code'=>'DL','origin'=>'New York', 'destination'=>'Amsterdam','gate'=>'E08','terminal'=>'E','type'=>'arriving','status'=>'op-tijd',   'scheduled_time'=>'16:20'],
            ['flight_number'=>'VY3456','airline'=>'Vueling',    'airline_code'=>'VY','origin'=>'Barcelona','destination'=>'Amsterdam','gate'=>'C31','terminal'=>'C','type'=>'arriving','status'=>'geland',    'scheduled_time'=>'17:10'],
            // vertrekkend
            ['flight_number'=>'IB7890','airline'=>'Iberia',    'airline_code'=>'IB','origin'=>'Amsterdam','destination'=>'Madrid',  'gate'=>'C31','terminal'=>'C','type'=>'departing','status'=>'boarding',  'scheduled_time'=>'13:15'],
            ['flight_number'=>'AZ2345','airline'=>'ITA Airways','airline_code'=>'AZ','origin'=>'Amsterdam','destination'=>'Rome',    'gate'=>'B09','terminal'=>'B','type'=>'departing','status'=>'vertraging','scheduled_time'=>'14:00','delay_minutes'=>10],
            ['flight_number'=>'A36780','airline'=>'Aegean',     'airline_code'=>'A3','origin'=>'Amsterdam','destination'=>'Athene',  'gate'=>'D17','terminal'=>'D','type'=>'departing','status'=>'op-tijd',   'scheduled_time'=>'15:30'],
            ['flight_number'=>'TK1234','airline'=>'Turkish',    'airline_code'=>'TK','origin'=>'Amsterdam','destination'=>'Istanbul','gate'=>'F04','terminal'=>'F','type'=>'departing','status'=>'op-tijd',   'scheduled_time'=>'16:45'],
        ];

        foreach ($flights as $flight) {
            Flight::create($flight);
        }
    }
}