<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'trip_id',
        'name',
        'email',
        'phone',
        'ic_number',
        'passport_number',
        'passport_file',
        'passport_expiry_date',
    ];

    protected $casts = [
        'passport_expiry_date' => 'date',
    ];

    // Relationships
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    // Bonus: passport expiry check (< 6 months before trip departure)
    public function isPassportExpiringSoon()
    {
        if (!$this->passport_expiry_date || !$this->trip) {
            return false;
        }

        $sixMonthsBeforeTrip = $this->trip->departure_date->copy()->subMonths(6);

        return $this->passport_expiry_date->lessThan($sixMonthsBeforeTrip);
    }
}