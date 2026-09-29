@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">My Bookings</h1>

@if($bookings->isEmpty())
    <div class="bg-white p-6 rounded shadow text-center text-gray-500">
        No bookings yet. <a href="{{ route('trips.index') }}" class="text-indigo-600 underline">Browse trips</a>.
    </div>
@else
    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Code</th>
                    <th class="px-4 py-3">Trip</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Pax</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Payment</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
            @foreach($bookings as $b)
                <tr class="border-t">
                    <td class="px-4 py-3 font-mono text-xs">{{ $b->booking_code }}</td>
                    <td class="px-4 py-3">{{ $b->trip->title ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $b->booking_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">{{ $b->total_participants }}</td>
                    <td class="px-4 py-3">RM {{ number_format($b->total_amount, 2) }}</td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs rounded bg-gray-100">{{ $b->status }}</span></td>
                    <td class="px-4 py-3"><span class="px-2 py-0.5 text-xs rounded bg-yellow-100 text-yellow-800">{{ $b->payment_status }}</span></td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('bookings.show', $b) }}" class="text-indigo-600 hover:underline">View</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $bookings->links() }}</div>
@endif
@endsection