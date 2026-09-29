@extends('layouts.app')

@section('content')
<a href="{{ route('admin.bookings.index') }}" class="text-sm text-indigo-600 hover:underline">← Back to Bookings</a>

<div class="bg-white rounded shadow p-6 mt-4 mb-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold">Booking {{ $booking->booking_code }}</h1>
            <p class="text-sm text-gray-500">Customer: {{ $booking->user->name }} ({{ $booking->user->email }})</p>
            <p class="text-sm text-gray-500">Booked: {{ $booking->booking_date->format('d M Y') }}</p>
        </div>
        <div class="text-right">
            <span class="px-2 py-0.5 text-xs rounded bg-gray-100">{{ $booking->status }}</span>
            <span class="px-2 py-0.5 text-xs rounded bg-yellow-100 text-yellow-800">{{ $booking->payment_status }}</span>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-6 text-sm">
        <div>
            <h2 class="font-semibold mb-2">Trip</h2>
            <p>{{ $booking->trip->title ?? '-' }}</p>
            <p class="text-gray-500">📍 {{ $booking->trip->destination ?? '-' }}</p>
            <p class="text-gray-500">🗓 {{ optional($booking->trip)->departure_date?->format('d M Y') }} → {{ optional($booking->trip)->return_date?->format('d M Y') }}</p>
        </div>
        <div>
            <h2 class="font-semibold mb-2">Amount</h2>
            <p>Participants: <strong>{{ $booking->total_participants }}</strong></p>
            <p>Total: <strong class="text-indigo-600">RM {{ number_format($booking->total_amount, 2) }}</strong></p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.bookings.status', $booking) }}" class="bg-gray-50 p-4 rounded border">
        @csrf @method('PATCH')
        <h3 class="font-semibold mb-3 text-sm">Update Status</h3>
        <div class="grid md:grid-cols-3 gap-3 items-end">
            <div>
                <label class="block text-xs text-gray-600 mb-1">Booking Status</label>
                <select name="status" class="w-full border rounded px-3 py-2 text-sm">
                    @foreach(['pending','confirmed','cancelled'] as $s)
                        <option value="{{ $s }}" @selected($booking->status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs text-gray-600 mb-1">Payment Status</label>
                <select name="payment_status" class="w-full border rounded px-3 py-2 text-sm">
                    @foreach(['pending','paid','failed','refunded'] as $s)
                        <option value="{{ $s }}" @selected($booking->payment_status === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <button class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 text-sm">Update</button>
        </div>
    </form>
</div>

<h2 class="font-semibold text-lg mb-3">Participants ({{ $booking->participants->count() }})</h2>
<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-left text-gray-600">
            <tr>
                <th class="px-3 py-2">#</th>
                <th class="px-3 py-2">Name</th>
                <th class="px-3 py-2">Email</th>
                <th class="px-3 py-2">Phone</th>
                <th class="px-3 py-2">IC</th>
                <th class="px-3 py-2">Passport</th>
                <th class="px-3 py-2">Expiry</th>
            </tr>
        </thead>
        <tbody>
        @foreach($booking->participants as $i => $p)
            <tr class="border-t">
                <td class="px-3 py-2">{{ $i + 1 }}</td>
                <td class="px-3 py-2">{{ $p->name }}</td>
                <td class="px-3 py-2">{{ $p->email ?? '-' }}</td>
                <td class="px-3 py-2">{{ $p->phone ?? '-' }}</td>
                <td class="px-3 py-2">{{ $p->ic_number ?? '-' }}</td>
                <td class="px-3 py-2">{{ $p->passport_number ?? '-' }}</td>
                <td class="px-3 py-2">
                    {{ $p->passport_expiry_date?->format('d M Y') ?? '-' }}
                    @if($p->isPassportExpiringSoon())
                        <span class="ml-1 text-xs px-1.5 py-0.5 rounded bg-red-100 text-red-700">⚠</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection