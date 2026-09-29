<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isCustomer()) {
            $bookings = Booking::with('trip')
                ->where('user_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            $stats = [
                'total_bookings' => Booking::where('user_id', $user->id)->count(),
                'pending' => Booking::where('user_id', $user->id)->where('payment_status', 'pending')->count(),
                'paid' => Booking::where('user_id', $user->id)->where('payment_status', 'paid')->count(),
                'available_trips' => Trip::where('status', 'open')->count(),
            ];

            return view('dashboard.customer', compact('bookings', 'stats'));
        }

        // Admin / Staff
        $stats = [
            'total_trips' => Trip::count(),
            'open_trips' => Trip::where('status', 'open')->count(),
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_participants' => \App\Models\Participant::count(),
        ];

        $recentBookings = Booking::with(['user', 'trip'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentBookings'));
    }
}