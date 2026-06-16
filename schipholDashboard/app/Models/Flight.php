<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $fillable = [
        'flight_number',
        'airline',
        'airline_code',
        'origin',
        'destination',
        'gate',
        'terminal',
        'type',
        'status',
        'scheduled_time',
        'delay_minutes',
        'seats_available',
        'price',
    ];

    /**
     * Relatie met Bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope: Aankomende vluchten
     */
    public function scopeArriving($query)
    {
        return $query->where('type', 'arriving');
    }

    /**
     * Scope: Vertrekkende vluchten
     */
    public function scopeDeparting($query)
    {
        return $query->where('type', 'departing');
    }

    /**
     * Prijs (berekend op basis van ID en bestemming)
     */
    public function getPriceAttribute(): float
    {
        // Als price al in de database staat, gebruik die
        if (isset($this->attributes['price']) && $this->attributes['price'] > 0) {
            return (float) $this->attributes['price'];
        }

        // Anders berekenen
        $seed = crc32($this->id . $this->destination);
        mt_srand(abs($seed));

        // Gebruik gate_type als die bestaat, anders standaard
        $gateType = $this->gate_type ?? 'standaard';
        if ($gateType === 'uitgebreid') {
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
        return in_array($this->status, ['op-tijd', 'vertraging', 'scheduled']);
    }

    /**
     * Beschikbare stoelen (met default)
     */
    public function getSeatsAvailableAttribute()
    {
        return $this->attributes['seats_available'] ?? 100;
    }
}