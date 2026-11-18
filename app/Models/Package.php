<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'destination',
        'country',
        'duration_days',
        'duration_nights',
        'hotel_id',
        'flight_id',
        'price',
        'discount_percent',
        'max_capacity',
        'available_slots',
        'image',
        'description',
        'itinerary',
        'inclusions',
        'exclusions',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'itinerary' => 'array',
        'inclusions' => 'array',
        'exclusions' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'discount_percent' => 'integer',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function getFinalPriceAttribute()
    {
        if ($this->discount_percent > 0) {
            return round($this->price - ($this->price * ($this->discount_percent / 100)), 2);
        }
        return $this->price;
    }
}
