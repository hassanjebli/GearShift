<select name="fuel_type_id">
    <option value="">Type de carburant</option>
    @foreach($fuelTypes as $fuelType)
        <option value="{{ $fuelType->id }}"
            @selected($attributes->get('value') == $fuelType->id)>{{ $fuelType->name }}</option>
    @endforeach
</select>
