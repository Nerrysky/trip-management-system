<div>
    <label class="block text-sm font-medium mb-1">Title *</label>
    <input name="title" value="{{ old('title', $trip->title ?? '') }}" required
           class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
    @error('title') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Destination *</label>
        <input name="destination" value="{{ old('destination', $trip->destination ?? '') }}" required
               class="w-full border rounded px-3 py-2 @error('destination') border-red-500 @enderror">
        @error('destination') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Price (RM) *</label>
        <input name="price" type="number" step="0.01" min="0"
               value="{{ old('price', $trip->price ?? '') }}" required
               class="w-full border rounded px-3 py-2 @error('price') border-red-500 @enderror">
        @error('price') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Departure Date *</label>
        <input name="departure_date" type="date"
               value="{{ old('departure_date', isset($trip) ? $trip->departure_date->format('Y-m-d') : '') }}" required
               class="w-full border rounded px-3 py-2 @error('departure_date') border-red-500 @enderror">
        @error('departure_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Return Date *</label>
        <input name="return_date" type="date"
               value="{{ old('return_date', isset($trip) ? $trip->return_date->format('Y-m-d') : '') }}" required
               class="w-full border rounded px-3 py-2 @error('return_date') border-red-500 @enderror">
        @error('return_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Max Capacity *</label>
        <input name="max_capacity" type="number" min="1"
               value="{{ old('max_capacity', $trip->max_capacity ?? 40) }}" required
               class="w-full border rounded px-3 py-2 @error('max_capacity') border-red-500 @enderror">
        @error('max_capacity') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Status *</label>
        <select name="status" class="w-full border rounded px-3 py-2">
            @foreach(['open','closed','cancelled'] as $s)
                <option value="{{ $s }}" @selected(old('status', $trip->status ?? 'open') === $s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Description</label>
    <textarea name="description" rows="4"
              class="w-full border rounded px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description', $trip->description ?? '') }}</textarea>
    @error('description') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
</div>