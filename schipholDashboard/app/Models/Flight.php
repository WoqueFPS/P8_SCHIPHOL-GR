<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'flight_number', 'airline', 'airline_code',
        'origin', 'destination', 'gate', 'terminal',
        'type', 'status', 'scheduled_time', 'delay_minutes',
    ];

    //scopes voor easy filters
    public function scopeArriving($query)
    {
        return $query->where('type', 'arriving');
    }

    public function scopeDeparting($query)
    {
        return $query->where('type', 'departing');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }
}