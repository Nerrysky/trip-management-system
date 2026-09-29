<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'trip_id',
        'booking_date',
        'total_participants',
        'total_amount',
        'payment_status',
        'status',
        'notes',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    // Helper: generate unique booking code
    public static function generateCode()
    {
        return 'TRP-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));
    }
}