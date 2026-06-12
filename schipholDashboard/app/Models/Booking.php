<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_number',
        'first_name',
        'last_name',
        'address',
        'email',
        'phone'
    ];
}
