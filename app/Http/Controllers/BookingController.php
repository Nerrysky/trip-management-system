<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Booking;
use App\Models\Participant;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Customer — show booking form for a trip
     */
    public function create(Trip $trip)
    {
        if ($trip->status !== 'open') {
            return redirect()->route('trips.index')->with('error', 'This trip is not open for booking.');
        }

        if ($trip->isFull()) {
            return redirect()->route('trips.show', $trip)->with('error', 'This trip is full.');
        }

        return view('bookings.create', compact('trip'));
    }

    /**
     * Customer — store booking + participants
     */
    public function store(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'participants' => 'required|array|min:1',
            'participants.*.name' => 'required|string|max:191',
            'participants.*.email' => 'nullable|email|max:191',
            'participants.*.phone' => 'nullable|string|max:20',
            'participants.*.ic_number' => 'nullable|string|max:50',
            'participants.*.passport_number' => 'nullable|string|max:50',
            'participants.*.passport_expiry_date' => 'nullable|date',
        ]);

        $count = count($validated['participants']);

        if ($trip->availableSeats() < $count) {
            return back()->with('error', "Only {$trip->availableSeats()} seats available.");
        }

        DB::transaction(function () use ($trip, $validated, $count) {
            $booking = Booking::create([
                'booking_code' => Booking::generateCode(),
                'user_id' => auth()->id(),
                'trip_id' => $trip->id,
                'booking_date' => now(),
                'total_participants' => $count,
                'total_amount' => $trip->price * $count,
                'payment_status' => 'pending',
                'status' => 'pending',
            ]);

            foreach ($validated['participants'] as $p) {
                Participant::create([
                    'booking_id' => $booking->id,
                    'trip_id' => $trip->id,
                    'name' => $p['name'],
                    'email' => $p['email'] ?? null,
                    'phone' => $p['phone'] ?? null,
                    'ic_number' => $p['ic_number'] ?? null,
                    'passport_number' => $p['passport_number'] ?? null,
                    'passport_expiry_date' => $p['passport_expiry_date'] ?? null,
                ]);
            }

            ActivityLog::log('booked', "New booking {$booking->booking_code} for trip {$trip->title}", $booking);
        });

        return redirect()->route('bookings.my')->with('success', 'Booking submitted successfully.');
    }

    /**
     * Customer — list own bookings
     */
    public function myBookings()
    {
        $bookings = Booking::with('trip')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('bookings.my', compact('bookings'));
    }

    /**
     * Customer — view a booking
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['trip', 'participants']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Admin/Staff — list all bookings
     */
    public function adminIndex(Request $request)
    {
        $query = Booking::with(['user', 'trip']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Admin/Staff — view a booking
     */
    public function adminShow(Booking $booking)
    {
        $booking->load(['user', 'trip', 'participants']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Admin/Staff — update booking status / payment
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $booking->update($validated);

        ActivityLog::log('updated', "Updated booking {$booking->booking_code}", $booking);

        return back()->with('success', 'Booking updated.');
    }
}