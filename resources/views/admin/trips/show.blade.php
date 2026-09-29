@extends('layouts.app')

@section('content')
<a href="{{ route('admin.trips.index') }}" class="text-sm text-indigo-600 hover:underline">← Back</a>

<div class="bg-white rounded shadow p-6 mt-4 mb-6">
    <div class="flex justify-between items-start mb-4">
        <h1 class="text-2xl font-bold">{{ $trip->title }}</h1>
        <span class="text-xs px-3 py-1 rounded bg-green-100 text-green-700 uppercase">{{ $trip->status }}</span>
    </div>
    <p class="text-gray-700 mb-4">{{ $trip->description }}</p>
    <div class="grid md:grid-cols-3 gap-4 text-sm">
        <div><span class="text-gray-500">Destination:</span> {{ $trip->destination }}</div>
        <div><span class="text-gray-500">Dates:</span> {{ $trip->departure_date->format('d M Y') }} → {{ $trip->return_date->format('d M Y') }}</div>
        <div><span class="text-gray-500">Price:</span> RM {{ number_format($trip->price, 2) }}</div>
        <div><span class="text-gray-500">Capacity:</span> {{ $trip->totalParticipants() }} / {{ $trip->max_capacity }}</div>
        <div><span class="text-gray-500">Available:</span> {{ $trip->availableSeats() }} seats</div>
        <div><span class="text-gray-500">Created by:</span> {{ $trip->creator->name ?? '-' }}</div>
    </div>
</div>

<h2 class="font-semibold text-lg mb-3">Bookings ({{ $trip->bookings->count() }})</h2>
<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left text-gray-600">
            <tr>
                <th class="px-4 py-3">Code</th>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Pax</th>
                <th class="px-4 py-3">Amount</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
        @forelse($trip->bookings as $b)
            <tr class="border-t">
                <td class="px-4 py-3 font-mono text-xs">{{ $b->booking_code }}</td>
                <td class="px-4 py-3">{{ $b->user->name ?? '-' }}</td>
                <td class="px-4 py-3">{{ $b->total_participants }}</td>
                <td class="px-4 py-3">RM {{ number_format($b->total_amount, 2) }}</td>
                <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs rounded bg-gray-100">{{ $b->status }}</span></td>
                <td class="px-4 py-3 text-right"><a href="{{ route('admin.bookings.show', $b) }}" class="text-indigo-600 hover:underline">View</a></td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No bookings for this trip yet.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection