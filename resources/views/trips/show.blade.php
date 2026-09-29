@extends('layouts.app')

@section('content')
<a href="{{ route('trips.index') }}" class="text-sm text-indigo-600 hover:underline">← Back to Trips</a>

<div class="bg-white rounded shadow p-6 mt-4">
    <div class="flex justify-between items-start mb-4">
        <div>
            <h1 class="text-2xl font-bold">{{ $trip->title }}</h1>
            <p class="text-gray-500">📍 {{ $trip->destination }}</p>
        </div>
        <span class="text-xs px-3 py-1 rounded bg-green-100 text-green-700 uppercase">{{ $trip->status }}</span>
    </div>

    <p class="text-gray-700 mb-6">{{ $trip->description }}</p>

    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div class="space-y-2 text-sm">
            <div><span class="text-gray-500">Departure:</span> <strong>{{ $trip->departure_date->format('d M Y') }}</strong></div>
            <div><span class="text-gray-500">Return:</span> <strong>{{ $trip->return_date->format('d M Y') }}</strong></div>
            <div><span class="text-gray-500">Duration:</span> <strong>{{ $trip->departure_date->diffInDays($trip->return_date) }} days</strong></div>
        </div>
        <div class="space-y-2 text-sm">
            <div><span class="text-gray-500">Price per person:</span> <strong class="text-indigo-600">RM {{ number_format($trip->price, 2) }}</strong></div>
            <div><span class="text-gray-500">Capacity:</span> <strong>{{ $trip->max_capacity }} pax</strong></div>
            <div><span class="text-gray-500">Registered:</span> <strong>{{ $participantCount }} pax</strong></div>
            <div>
                <span class="text-gray-500">Available seats:</span>
                <strong class="{{ $availableSeats > 0 ? 'text-green-600' : 'text-red-600' }}">{{ $availableSeats }}</strong>
            </div>
        </div>
    </div>

    @if($availableSeats <= 0)
        <div class="p-3 rounded bg-red-100 text-red-800 mb-4">This trip is fully booked.</div>
        <button disabled class="bg-gray-300 text-gray-600 px-5 py-2.5 rounded cursor-not-allowed">Trip Full</button>
    @elseif($trip->status !== 'open')
        <div class="p-3 rounded bg-yellow-100 text-yellow-800 mb-4">This trip is not open for booking.</div>
    @else
        <a href="{{ route('bookings.create', $trip) }}"
           class="inline-block bg-indigo-600 text-white px-6 py-2.5 rounded hover:bg-indigo-700 font-semibold">
           Book Now
        </a>
    @endif
</div>
@endsection