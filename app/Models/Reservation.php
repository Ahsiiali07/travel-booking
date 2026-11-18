<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'user_id',
        'type',
        'flight_id',
        'hotel_id',
        'package_id',
        'travel_date',
        'check_in_date',
        'check_out_date',
        'guests_count',
        'room_type',
        'seat_class',
        'seat_number',
        'contact_name',
        'contact_email',
        'contact_phone',
        'passenger_details',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'payment_status',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'passenger_details' => 'array',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public static function generateReference(): string
    {
        do {
            $ref = 'TRV-' . date('Y') . '-' . strtoupper(Str::random(6));
        } while (self::where('booking_reference', $ref)->exists());

        return $ref;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function refund()
    {
        return $this->hasOne(Refund::class);
    }

    public function getItemNameAttribute(): string
    {
        if ($this->type === 'flight' && $this->flight) {
            return $this->flight->airline . ' (' . $this->flight->origin_city . ' to ' . $this->flight->destination_city . ')';
        }
        if ($this->type === 'hotel' && $this->hotel) {
            return $this->hotel->name . ' (' . $this->hotel->city . ')';
        }
        if ($this->type === 'package' && $this->package) {
            return $this->package->name . ' (' . $this->package->destination . ')';
        }
        return 'Travel Booking #' . $this->booking_reference;
    }
}
