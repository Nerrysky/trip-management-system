@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">All Bookings</h1>

<form method="GET" class="bg-white p-4 rounded shadow mb-6 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[200px]">
        <label class="block text-sm text-gray-600 mb-1">Search</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Booking code or customer name"
               class="w-full border rounded px-3 py-2">
    </div>
    <div>
        <label class="block text-sm text-gray-600 mb-1">Status</label>
        <select name="status" class="border rounded px-3 py-2">
            <option value="">All</option>
            @foreach(['pending','confirmed','cancelled'] as $s)
                <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Filter</button>
</form>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left text-gray-600">
            <tr>
                <th class="px-4 py-3">Code</th>
                <th class="px-4 py-3">Customer</th>
                <th class="px-4 py-3">Trip</th>
                <th class="px-4 py-3">Pax</th>
                <th class="px-4 py-3">Amount</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Payment</th>
                <th class="px-4 py-3"></th>
            </tr>
        </thead>
        <tbody>
        @forelse($bookings as $b)
            <tr class="border-t">
                <td class="px-4 py-3 font-mono text-xs">{{ $b->booking_code }}</td>
                <td class="px-4 py-3">{{ $b->user->name ?? '-' }}</td>
                <td class="px-4 py-3">{{ $b->trip->title ?? '-' }}</td>
                <td class="px-4 py-3">{{ $b->total_participants }}</td>
                <td class="px-4 py-3">RM {{ number_format($b->total_amount, 2) }}</td>
                <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs rounded bg-gray-100">{{ $b->status }}</span></td>
                <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs rounded bg-yellow-100 text-yellow-800">{{ $b->payment_status }}</span></td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.bookings.show', $b) }}" class="text-indigo-600 hover:underline">View</a>
                </td>
            </tr>
        @empty
            <tr><td colspan="8" class="px-4 py-6 text-center text-gray-500">No bookings found.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $bookings->links() }}</div>
@endsection