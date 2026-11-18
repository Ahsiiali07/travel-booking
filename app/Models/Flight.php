<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;

    protected $fillable = [
        'airline',
        'flight_number',
        'origin_city',
        'destination_city',
        'origin_airport',
        'destination_airport',
        'departure_time',
        'arrival_time',
        'duration',
        'seat_class',
        'total_seats',
        'available_seats',
        'price_per_seat',
        'baggage_allowance',
        'aircraft_type',
        'image',
        'status',
    ];

    protected $casts = [
        'departure_time' => 'datetime',
        'arrival_time' => 'datetime',
        'price_per_seat' => 'decimal:2',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function packages()
    {
        return $this->hasMany(Package::class);
    }
}
