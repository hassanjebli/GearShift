<select id="citySelect" name="city_id">
  <option value="">Ville</option>
  @foreach ($cities as $city)
    <option value="{{ $city->id }}" data-parent="{{ $city->state_id }}" @selected($attributes->get('value') == $city->id)>
      {{ $city->name }}
    </option>
  @endforeach
</select>
