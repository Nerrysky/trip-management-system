<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Admin/Staff — list all trips
     */
    public function index(Request $request)
    {
        $query = Trip::with('creator');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $trips = $query->latest()->paginate(10)->withQueryString();

        return view('admin.trips.index', compact('trips'));
    }

    /**
     * Admin/Staff — show create form
     */
    public function create()
    {
        return view('admin.trips.create');
    }

    /**
     * Admin/Staff — store new trip
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'destination' => 'required|string|max:191',
            'description' => 'nullable|string',
            'departure_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:departure_date',
            'price' => 'required|numeric|min:0',
            'max_capacity' => 'required|integer|min:1',
            'status' => 'required|in:open,closed,cancelled',
        ]);

        $validated['created_by'] = auth()->id();

        $trip = Trip::create($validated);

        ActivityLog::log('created', "Created trip: {$trip->title}", $trip);

        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip created successfully.');
    }

    /**
     * Admin/Staff — show edit form
     */
    public function edit(Trip $trip)
    {
        return view('admin.trips.edit', compact('trip'));
    }

    /**
     * Admin/Staff — update trip
     */
    public function update(Request $request, Trip $trip)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:191',
            'destination' => 'required|string|max:191',
            'description' => 'nullable|string',
            'departure_date' => 'required|date',
            'return_date' => 'required|date|after:departure_date',
            'price' => 'required|numeric|min:0',
            'max_capacity' => 'required|integer|min:1',
            'status' => 'required|in:open,closed,cancelled',
        ]);

        $trip->update($validated);

        ActivityLog::log('updated', "Updated trip: {$trip->title}", $trip);

        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip updated successfully.');
    }

    /**
     * Admin/Staff — delete trip
     */
    public function destroy(Trip $trip)
    {
        $trip->delete();
        ActivityLog::log('deleted', "Deleted trip: {$trip->title}");

        return redirect()->route('admin.trips.index')
            ->with('success', 'Trip deleted.');
    }

    /**
     * Customer — list open trips
     */
    public function publicIndex(Request $request)
    {
        $query = Trip::where('status', 'open');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%");
            });
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'price_asc') $query->orderBy('price', 'asc');
            if ($request->sort === 'price_desc') $query->orderBy('price', 'desc');
            if ($request->sort === 'departure') $query->orderBy('departure_date', 'asc');
        } else {
            $query->orderBy('departure_date', 'asc');
        }

        $trips = $query->paginate(9)->withQueryString();

        return view('trips.index', compact('trips'));
    }

    /**
     * Customer — view trip detail
     */
    public function publicShow(Trip $trip)
    {
        $trip->load('creator');
        $participantCount = $trip->totalParticipants();
        $availableSeats = $trip->availableSeats();

        return view('trips.show', compact('trip', 'participantCount', 'availableSeats'));
    }

    /**
     * Admin/Staff — view single trip (from admin panel)
     */
    public function show(Trip $trip)
    {
        $trip->load(['creator', 'bookings.user', 'participants']);
        return view('admin.trips.show', compact('trip'));
    }
}