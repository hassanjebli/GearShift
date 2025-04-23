@php
  $options = [
      '10000',
      '20000',
      '30000',
      '40000',
      '50000',
      '60000',
      '70000',
      '80000',
      '90000',
      '100000',
      '150000',
      '200000',
      '250000',
      '300000',
  ];
@endphp

<select name="mileage">
  <option value="">Kilométrage quelconque</option>
  @foreach ($options as $option)
    <option value="{{ $option }}" @selected($attributes->get('value') == $option)>{{ number_format($option) }} or less</option>
  @endforeach
</select>
