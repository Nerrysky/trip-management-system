@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">Manage Trips</h1>
    <a href="{{ route('admin.trips.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ New Trip</a>
</div>

<form method="GET" class="bg-white p-4 rounded shadow mb-6 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[200px]">
        <label class="block text-sm text-gray-600 mb-1">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Title or destination"
               class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm text-gray-600 mb-1">Status</label>
        <select name="status" class="border rounded px-3 py-2">
            <option value="">All</option>
            <option value="open" @selected(request('status') === 'open')>Open</option>
            <option value="closed" @selected(request('status') === 'closed')>Closed</option>
            <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Filter</button>
</form>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left text-gray-600">
            <tr>
                <th class="px-4 py-3">Title</th>
                <th class="px-4 py-3">Destination</th>
                <th class="px-4 py-3">Dates</th>
                <th class="px-4 py-3">Price</th>
                <th class="px-4 py-3">Seats</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($trips as $trip)
            <tr class="border-t">
                <td class="px-4 py-3 font-medium">{{ $trip->title }}</td>
                <td class="px-4 py-3">{{ $trip->destination }}</td>
                <td class="px-4 py-3 text-xs">{{ $trip->departure_date->format('d M Y') }} → {{ $trip->return_date->format('d M Y') }}</td>
                <td class="px-4 py-3">RM {{ number_format($trip->price, 2) }}</td>
                <td class="px-4 py-3">
                    {{ $trip->totalParticipants() }} / {{ $trip->max_capacity }}
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 text-xs rounded
                        @if($trip->status === 'open') bg-green-100 text-green-700
                        @elseif($trip->status === 'closed') bg-yellow-100 text-yellow-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ $trip->status }}
                    </span>
                </td>
                <td class="px-4 py-3 text-right space-x-2">
                    <a href="{{ route('admin.trips.show', $trip) }}" class="text-gray-600 hover:underline">View</a>
                    <a href="{{ route('admin.trips.edit', $trip) }}" class="text-indigo-600 hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.trips.destroy', $trip) }}" class="inline"
                          onsubmit="return confirm('Delete this trip?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">No trips found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $trips->links() }}</div>
@endsection