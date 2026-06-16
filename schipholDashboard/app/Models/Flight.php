<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'flight_number',
        'airline',
        'airline_code',
        'airline_logo',
        'origin',
        'destination',
        'gate',
        'terminal',
        'type',
        'status',
        'scheduled_time',
        'delay_minutes',
        'gate_type',
    ];


    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class);
    }


    public function scopeArriving($query)
    {
        return $query->where('type', 'arriving');
    }

    public function scopeDeparting($query)
    {
        return $query->where('type', 'departing');
    }


    /**
     * Consistente prijs op basis van vlucht-ID — zelfde vlucht = zelfde prijs altijd.
     */
    public function getPriceAttribute(): float
    {
        $seed = crc32($this->id . $this->destination);
        mt_srand(abs($seed));

        if ($this->gate_type === 'uitgebreid') {
            $base = mt_rand(280, 650);
        } else {
            $base = mt_rand(89, 279);
        }

        return floor($base) + 0.99;
    }

    /**
     * Luchthavenbelasting (20% van basisprijs)
     */
    public function getTaxAttribute(): float
    {
        return round($this->price * 0.20, 2);
    }

    /**
     * Totaalprijs inclusief belasting
     */
    public function getTotalPriceAttribute(): float
    {
        return round($this->price + $this->tax, 2);
    }

    /**
     * Of de vlucht boekbaar is
     */
    public function getIsBookableAttribute(): bool
    {
        return in_array($this->status, ['op-tijd', 'vertraging']);
    }
}