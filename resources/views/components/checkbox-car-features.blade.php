@props(['car' => null])

@php
  $features = [
      'air_conditioning' => 'Climatisation',
      'power_windows' => 'Vitres électriques',
      'power_door_locks' => 'Verrouillage centralisé',
      'abs' => 'ABS',
      'cruise_control' => 'Régulateur de vitesse',
      'bluetooth_connectivity' => 'Connectivité Bluetooth',
      'remote_start' => 'Démarrage à distance',
      'gps_navigation' => 'Système de navigation GPS',
      'heated_seats' => 'Sièges chauffants',
      'climate_control' => 'Contrôle climatique',
      'rear_parking_sensors' => 'Capteurs de stationnement arrière',
      'leather_seats' => 'Sièges en cuir',
  ];

@endphp

<div class="form-group">
  <div class="row">
    <div class="col">
      @foreach ($features as $key => $feature)
        <label class="checkbox">
          <input type="checkbox" name="features[{{ $key }}]" value="1" @checked(old('features.' . $key, $car?->features->$key)) />
          {{ $feature }}
        </label>

        @if ($loop->iteration % 6 == 0 && !$loop->last)
    </div>
    <div class="col">
      @endif
      @endforeach
    </div>
  </div>
</div>
