@extends('layouts.app')

@section('content')
<a href="{{ route('trips.show', $trip) }}" class="text-sm text-indigo-600 hover:underline">← Back to Trip</a>

<h1 class="text-2xl font-bold mt-4 mb-6">Book: {{ $trip->title }}</h1>

<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
        <form method="POST" action="{{ route('bookings.store', $trip) }}" id="bookingForm" class="space-y-4">
            @csrf

            <div id="participants">
                <!-- participant block template rendered by JS -->
            </div>

            <button type="button" onclick="addParticipant()"
                    class="text-sm bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded">+ Add Participant</button>

            @error('participants') <div class="text-red-600 text-sm">{{ $message }}</div> @enderror

            <div class="pt-4 border-t">
                <button class="bg-indigo-600 text-white px-6 py-2.5 rounded hover:bg-indigo-700 font-semibold">
                    Confirm Booking
                </button>
            </div>
        </form>
    </div>

    <aside class="bg-white rounded shadow p-5 h-fit">
        <h2 class="font-bold mb-3">Trip Summary</h2>
        <div class="text-sm space-y-2">
            <div class="flex justify-between"><span class="text-gray-500">Destination</span><span>{{ $trip->destination }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Departure</span><span>{{ $trip->departure_date->format('d M Y') }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Price/pax</span><span>RM {{ number_format($trip->price, 2) }}</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Seats left</span><span>{{ $trip->availableSeats() }}</span></div>
        </div>
        <div class="mt-4 pt-4 border-t flex justify-between font-bold">
            <span>Total</span>
            <span id="totalAmount" class="text-indigo-600">RM 0.00</span>
        </div>
    </aside>
</div>

<script>
    const price = {{ $trip->price }};
    let idx = 0;

    function addParticipant() {
        const i = idx++;
        const html = `
            <div class="bg-white p-4 rounded shadow mb-3 participant-block">
                <div class="flex justify-between mb-2">
                    <strong class="text-sm">Participant #${i + 1}</strong>
                    <button type="button" class="text-xs text-red-600" onclick="removeParticipant(this)">Remove</button>
                </div>
                <div class="grid md:grid-cols-2 gap-3">
                    <input name="participants[${i}][name]" placeholder="Full name *" required class="border rounded px-3 py-2 md:col-span-2">
                    <input name="participants[${i}][email]" type="email" placeholder="Email" class="border rounded px-3 py-2">
                    <input name="participants[${i}][phone]" placeholder="Phone" class="border rounded px-3 py-2">
                    <input name="participants[${i}][ic_number]" placeholder="IC Number" class="border rounded px-3 py-2">
                    <input name="participants[${i}][passport_number]" placeholder="Passport Number" class="border rounded px-3 py-2">
                    <div class="md:col-span-2">
                        <label class="text-xs text-gray-500">Passport Expiry Date</label>
                        <input name="participants[${i}][passport_expiry_date]" type="date" class="border rounded px-3 py-2 w-full">
                    </div>
                </div>
            </div>
        `;
        document.getElementById('participants').insertAdjacentHTML('beforeend', html);
        recalc();
    }

    function removeParticipant(btn) {
        btn.closest('.participant-block').remove();
        recalc();
    }

    function recalc() {
        const n = document.querySelectorAll('.participant-block').length;
        document.getElementById('totalAmount').innerText = 'RM ' + (n * price).toFixed(2);
    }

    addParticipant();
</script>
@endsection