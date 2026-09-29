@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Customer Dashboard</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-4 rounded shadow">
        <div class="text-sm text-gray-500">My Bookings</div>
        <div class="text-2xl font-bold">{{ $stats['total_bookings'] }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <div class="text-sm text-gray-500">Pending Payment</div>
        <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <div class="text-sm text-gray-500">Paid</div>
        <div class="text-2xl font-bold text-green-600">{{ $stats['paid'] }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <div class="text-sm text-gray-500">Available Trips</div>
        <div class="text-2xl font-bold text-indigo-600">{{ $stats['available_trips'] }}</div>
    </div>
</div>

<div class="bg-white rounded shadow p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-semibold text-lg">Recent Bookings</h2>
        <a href="{{ route('trips.index') }}" class="text-sm text-indigo-600 hover:underline">Browse Trips →</a>
    </div>
    @if($bookings->isEmpty())
        <p class="text-gray-500">No bookings yet. <a href="{{ route('trips.index') }}" class="text-indigo-600 underline">Find a trip</a>.</p>
    @else
        <table class="w-full text-sm">
            <thead class="text-left text-gray-500 border-b">
                <tr>
                    <th class="pb-2">Code</th>
                    <th class="pb-2">Trip</th>
                    <th class="pb-2">Participants</th>
                    <th class="pb-2">Status</th>
                    <th class="pb-2">Payment</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @foreach($bookings as $b)
                <tr class="border-b last:border-0">
                    <td class="py-2 font-mono text-xs">{{ $b->booking_code }}</td>
                    <td class="py-2">{{ $b->trip->title ?? '-' }}</td>
                    <td class="py-2">{{ $b->total_participants }}</td>
                    <td class="py-2"><span class="px-2 py-0.5 text-xs rounded bg-gray-100">{{ $b->status }}</span></td>
                    <td class="py-2"><span class="px-2 py-0.5 text-xs rounded bg-yellow-100 text-yellow-800">{{ $b->payment_status }}</span></td>
                    <td class="py-2 text-right"><a href="{{ route('bookings.show', $b) }}" class="text-indigo-600 hover:underline">View</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection