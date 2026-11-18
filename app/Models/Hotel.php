<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'country',
        'address',
        'star_rating',
        'price_per_night',
        'total_rooms',
        'available_rooms',
        'room_types',
        'amenities',
        'description',
        'image',
        'contact_phone',
        'contact_email',
        'status',
    ];

    protected $casts = [
        'room_types' => 'array',
        'amenities' => 'array',
        'price_per_night' => 'decimal:2',
        'star_rating' => 'integer',
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
