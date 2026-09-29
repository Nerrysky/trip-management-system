<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'destination',
        'departure_date',
        'return_date',
        'price',
        'max_capacity',
        'status',
        'created_by',
    ];

    protected $casts = [
        'departure_date' => 'date',
        'return_date' => 'date',
        'price' => 'decimal:2',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    // Helpers
    public function totalParticipants()
    {
        return $this->participants()->count();
    }

    public function availableSeats()
    {
        return max(0, $this->max_capacity - $this->totalParticipants());
    }

    public function isFull()
    {
        return $this->availableSeats() <= 0;
    }
}