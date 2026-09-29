@extends('layouts.app')

@section('content')
<a href="{{ route('admin.trips.index') }}" class="text-sm text-indigo-600 hover:underline">← Back</a>
<h1 class="text-2xl font-bold mt-4 mb-6">Edit Trip: {{ $trip->title }}</h1>

<form method="POST" action="{{ route('admin.trips.update', $trip) }}" class="bg-white rounded shadow p-6 space-y-4 max-w-3xl">
    @csrf @method('PUT')
    @include('admin.trips._form')

    <div class="pt-4 border-t">
        <button class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700">Update Trip</button>
    </div>
</form>
@endsection