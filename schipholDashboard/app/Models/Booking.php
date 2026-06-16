<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_number',
        'flight_id',
        'user_id',
        'first_name',
        'last_name',
        'address',
        'email',
        'phone',
        'status',
    ];

    /**
     * Relatie met Flight
     */
    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    /**
     * Relatie met User (als de boeking is ingelogd)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor voor volledige naam
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Accessor voor geformatteerde datum
     */
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d-m-Y H:i');
    }
}