@extends('layouts.app')

@section('content')
<a href="{{ route('bookings.my') }}" class="text-sm text-indigo-600 hover:underline">← Back to My Bookings</a>

<div class="bg-white rounded shadow p-6 mt-4">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h1 class="text-2xl font-bold">Booking {{ $booking->booking_code }}</h1>
            <p class="text-sm text-gray-500">Booked on {{ $booking->booking_date->format('d M Y') }}</p>
        </div>
        <div class="text-right text-sm">
            <div><span class="px-2 py-0.5 text-xs rounded bg-gray-100">{{ $booking->status }}</span></div>
            <div class="mt-1"><span class="px-2 py-0.5 text-xs rounded bg-yellow-100 text-yellow-800">{{ $booking->payment_status }}</span></div>
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
            <h2 class="font-semibold mb-2">Payment</h2>
            <p>Participants: <strong>{{ $booking->total_participants }}</strong></p>
            <p>Total: <strong class="text-indigo-600">RM {{ number_format($booking->total_amount, 2) }}</strong></p>
        </div>
    </div>

    <h2 class="font-semibold mb-3">Participants</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-sm border">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 py-2 text-left">#</th>
                    <th class="px-3 py-2 text-left">Name</th>
                    <th class="px-3 py-2 text-left">IC</th>
                    <th class="px-3 py-2 text-left">Passport</th>
                    <th class="px-3 py-2 text-left">Passport Expiry</th>
                </tr>
            </thead>
            <tbody>
            @foreach($booking->participants as $i => $p)
                <tr class="border-t">
                    <td class="px-3 py-2">{{ $i + 1 }}</td>
                    <td class="px-3 py-2">{{ $p->name }}</td>
                    <td class="px-3 py-2">{{ $p->ic_number ?? '-' }}</td>
                    <td class="px-3 py-2">{{ $p->passport_number ?? '-' }}</td>
                    <td class="px-3 py-2">
                        {{ $p->passport_expiry_date?->format('d M Y') ?? '-' }}
                        @if($p->isPassportExpiringSoon())
                            <span class="ml-2 text-xs px-2 py-0.5 rounded bg-red-100 text-red-700">⚠ &lt;6 months</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection