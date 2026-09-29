@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Available Trips</h1>
</div>

<form method="GET" class="bg-white p-4 rounded shadow mb-6 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[200px]">
        <label class="block text-sm text-gray-600 mb-1">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Title or destination"
               class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm text-gray-600 mb-1">Sort by</label>
        <select name="sort" class="border rounded px-3 py-2">
            <option value="">Departure (soonest)</option>
            <option value="price_asc" @selected(request('sort') === 'price_asc')>Price (low → high)</option>
            <option value="price_desc" @selected(request('sort') === 'price_desc')>Price (high → low)</option>
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Filter</button>
    @if(request()->hasAny(['search', 'sort']))
        <a href="{{ route('trips.index') }}" class="text-sm text-gray-500 underline">Clear</a>
    @endif
</form>

@if($trips->isEmpty())
    <div class="bg-white p-6 rounded shadow text-center text-gray-500">No trips available.</div>
@else
    <div class="grid md:grid-cols-3 gap-6">
        @foreach($trips as $trip)
            <div class="bg-white rounded shadow overflow-hidden flex flex-col">
                <div class="p-5 flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <h2 class="font-bold text-lg">{{ $trip->title }}</h2>
                        <span class="text-xs px-2 py-0.5 rounded bg-green-100 text-green-700 uppercase">{{ $trip->status }}</span>
                    </div>
                    <p class="text-sm text-gray-500 mb-3">📍 {{ $trip->destination }}</p>
                    <p class="text-sm text-gray-700 mb-4 line-clamp-2">{{ Str::limit($trip->description, 100) }}</p>
                    <div class="text-sm text-gray-600 space-y-1">
                        <div>🗓 {{ $trip->departure_date->format('d M Y') }} → {{ $trip->return_date->format('d M Y') }}</div>
                        <div>👥 {{ $trip->availableSeats() }} / {{ $trip->max_capacity }} seats left</div>
                    </div>
                </div>
                <div class="px-5 py-4 bg-gray-50 flex justify-between items-center">
                    <span class="font-bold text-indigo-600">RM {{ number_format($trip->price, 2) }}</span>
                    <a href="{{ route('trips.show', $trip) }}"
                       class="text-sm bg-indigo-600 text-white px-3 py-1.5 rounded hover:bg-indigo-700">View</a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $trips->links() }}</div>
@endif
@endsection