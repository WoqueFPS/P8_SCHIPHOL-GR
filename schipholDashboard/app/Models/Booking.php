<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_number',
        'flight_id',
        'first_name',
        'last_name',
        'address',
        'email',
        'phone',
    ];

    public function traveler()
    {
        return $this->belongsTo(\App\Models\Traveler::class);
    }

    public function flight()
    {
        return $this->belongsTo(\App\Models\Flight::class);
    }
}