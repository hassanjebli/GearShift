@php
  $year = date('Y');
@endphp

<select name="year">
  <option value="">Année</option>
  @for ($i = $year; $i >= 1970; $i--)
    <option value="{{ $i }}" @selected($attributes->get('value') == $i)>{{ $i }}</option>
  @endfor
</select>
