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
     * Bereken realistische prijs op basis van bestemming en afstand
     */
    public function getPriceAttribute(): float
    {
        // Als price al in de database staat, gebruik die
        if (isset($this->attributes['price']) && $this->attributes['price'] > 0) {
            return (float) $this->attributes['price'];
        }

        // Basis prijzen per regio (in euros)
        $prices = [
            // Europa (korte vluchten)
            'London' => [80, 150],
            'Paris' => [70, 130],
            'Berlin' => [90, 160],
            'Madrid' => [100, 190],
            'Rome' => [110, 200],
            'Barcelona' => [100, 180],
            'Lisbon' => [120, 220],
            'Dublin' => [85, 155],
            'Vienna' => [95, 170],
            'Prague' => [90, 165],
            'Budapest' => [100, 175],
            'Warsaw' => [95, 160],
            'Stockholm' => [110, 195],
            'Oslo' => [115, 200],
            'Copenhagen' => [105, 185],
            'Helsinki' => [120, 210],
            'Athens' => [130, 240],
            'Istanbul' => [140, 260],
            'Kuwait City' => [180, 350],
            'Dubai' => [200, 400],
            'Abu Dhabi' => [190, 380],
            'Doha' => [185, 370],
            
            // Noord-Amerika
            'New York' => [350, 650],
            'Toronto' => [320, 590],
            'Chicago' => [340, 620],
            'Los Angeles' => [400, 750],
            'Miami' => [360, 680],
            'Boston' => [330, 610],
            'Washington' => [340, 630],
            'San Francisco' => [420, 780],
            'Vancouver' => [350, 640],
            'Montreal' => [310, 580],
            
            // Zuid-Amerika
            'Sao Paulo' => [380, 720],
            'Rio de Janeiro' => [390, 740],
            'Buenos Aires' => [400, 760],
            'Mexico City' => [350, 660],
            'Bogota' => [340, 630],
            'Lima' => [360, 680],
            
            // Azie
            'Tokyo' => [450, 850],
            'Beijing' => [420, 790],
            'Shanghai' => [410, 770],
            'Hong Kong' => [430, 810],
            'Singapore' => [440, 830],
            'Bangkok' => [380, 720],
            'Kuala Lumpur' => [390, 740],
            'Seoul' => [430, 800],
            'Mumbai' => [370, 700],
            'Delhi' => [360, 680],
            'Jakarta' => [400, 750],
            
            // Afrika
            'Cape Town' => [420, 790],
            'Johannesburg' => [400, 750],
            'Nairobi' => [380, 710],
            'Cairo' => [320, 600],
            'Casablanca' => [280, 520],
            'Tunis' => [260, 480],
            
            // Oceanie
            'Sydney' => [500, 950],
            'Melbourne' => [510, 960],
            'Auckland' => [490, 930],
            
            // Midden-Oosten (extra)
            'Tehran' => [250, 460],
            'Riyadh' => [220, 410],
            'Jeddah' => [230, 420],
            'Muscat' => [210, 390],
            'Manama' => [200, 370],
            
            // Overig / standaard
            'default' => [99, 250],
        ];

        // Zoek de bestemming in de array
        $destination = $this->destination;
        $priceRange = null;
        
        foreach ($prices as $key => $range) {
            if (strpos($destination, $key) !== false) {
                $priceRange = $range;
                break;
            }
        }

        // Als geen match, gebruik default
        if (!$priceRange) {
            $priceRange = $prices['default'];
        }

        // Genereer een consistente prijs op basis van flight ID
        // Zo blijft de prijs hetzelfde voor dezelfde vlucht
        $seed = crc32($this->id . $this->destination . $this->airline);
        mt_srand(abs($seed));
        
        $min = $priceRange[0];
        $max = $priceRange[1];
        
        // Random prijs binnen de range, afgerond op 5 of 9
        $price = mt_rand($min, $max);
        
        // Rond af op 9 of 5 voor realistische prijzen
        $lastDigit = $price % 10;
        if ($lastDigit < 5) {
            $price = $price - $lastDigit + 5;
        } else {
            $price = $price - $lastDigit + 9;
        }
        
        // Zorg dat de prijs niet onder de minimum komt
        if ($price < $min) {
            $price = $min;
        }
        
        return (float) $price;
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