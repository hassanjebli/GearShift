@php
    $isInWatchlist = $car->isInWatchlist(\Illuminate\Support\Facades\Auth::user());
@endphp

<x-app-layout>
    <main>
        <div class="container">
            <h1 class="car-details-page-title">{{ $car->maker->name }}
                {{ $car->model->name }} - {{ $car->year }}</h1>
            <div class="car-details-region">{{ $car->city->name }} -
                {{ $car->published_at }}</div>

            <div class="car-details-content">
                <div class="car-images-and-description">
                    <div class="car-images-carousel">
                        <div class="car-image-wrapper">
                            <img src="{{ $car->primaryImage?->getUrl() ?: '/img/no_image.jpg' }}" alt=""
                                class="car-active-image" id="activeImage" />
                        </div>
                        <div class="car-image-thumbnails">
                            @foreach ($car->images as $image)
                                <img src="{{ $image->getUrl() }}" alt="" />
                            @endforeach
                        </div>
                        <button class="carousel-button prev-button" id="prevButton">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" style="width: 64px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                            </svg>
                        </button>
                        <button class="carousel-button next-button" id="nextButton">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" style="width: 64px">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>

                    <div class="card car-detailed-description">
                        <h2 class="car-details-title">Description détaillée</h2>
                        {!! $car->description !!}
                    </div>

                    <div class="card car-detailed-description">
                        <h2 class="car-details-title">Spécifications de la voiture</h2>

                        <ul class="car-specifications">
                            <x-car-specification :value="$car->features->air_conditioning">
                                Climatisation
                            </x-car-specification>
                            <x-car-specification :value="$car->features->power_windows">
                                Vitres électriques
                            </x-car-specification>
                            <x-car-specification :value="$car->features->power_door_locks">
                                Verrouillage centralisé
                            </x-car-specification>
                            <x-car-specification :value="$car->features->abs">
                                ABS
                            </x-car-specification>
                            <x-car-specification :value="$car->features->cruise_control">
                                Régulateur de vitesse
                            </x-car-specification>
                            <x-car-specification :value="$car->features->bluetooth_connectivity">
                                Connectivité Bluetooth
                            </x-car-specification>
                            <x-car-specification :value="$car->features->remote_start">
                                Démarrage à distance
                            </x-car-specification>
                            <x-car-specification :value="$car->features->gps_navigation">
                                Système de navigation GPS
                            </x-car-specification>
                            <x-car-specification :value="$car->features->heated_seats">
                                Sièges chauffants
                            </x-car-specification>
                            <x-car-specification :value="$car->features->climate_control">
                                Contrôle climatique
                            </x-car-specification>
                            <x-car-specification :value="$car->features->rear_parking_sensors">
                                Capteurs de stationnement arrière
                            </x-car-specification>
                            <x-car-specification :value="$car->features->leather_seats">
                                Sièges en cuir
                            </x-car-specification>
                        </ul>
                    </div>

                </div>
                <div class="car-details card">
                    <div class="flex items-center justify-between">
                        <p class="car-details-price">${{ $car->price }}</p>
                        <button class="btn-heart text-primary" data-url="{{ route('watchlist.storeDestroy', $car) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" style="width: 16px"
                                @class([
                                    'hidden' => $isInWatchlist,
                                ])>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                style="width: 16px" @class([
                                    'hidden' => !$isInWatchlist,
                                ])>
                                <path
                                    d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
                            </svg>
                        </button>
                    </div>

                    <hr />
                    <table class="car-details-table">
                        <tbody>
                            <tr>
                                <th>Marque</th>
                                <td>{{ $car->maker->name }}</td>
                            </tr>
                            <tr>
                                <th>Modèle</th>
                                <td>{{ $car->model->name }}</td>
                            </tr>
                            <tr>
                                <th>Année</th>
                                <td>{{ $car->year }}</td>
                            </tr>
                            <tr>
                                <th>VIN</th>
                                <td>{{ $car->vin }}</td>
                            </tr>
                            <tr>
                                <th>Kilométrage</th>
                                <td>{{ $car->mileage }}</td>
                            </tr>
                            <tr>
                                <th>Type de voiture</th>
                                <td>{{ $car->carType->name }}</td>
                            </tr>
                            <tr>
                                <th>Type de carburant</th>
                                <td>{{ $car->fuelType->name }}</td>
                            </tr>
                            <tr>
                                <th>Adresse</th>
                                <td>{{ $car->address }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <hr />

                    <div class="flex gap-1 my-medium">
                        <img src="/img/avatar.png" alt="" class="car-details-owner-image" />
                        <div>
                            <h3 class="car-details-owner">{{ $car->owner->name }}</h3>
                            <div class="text-muted">{{ $car->owner->cars()->count() }} Voitures</div>
                        </div>
                    </div>
                    <a href="tel:{{ \Illuminate\Support\Str::mask($car->phone, '*', -3) }}" class="car-details-phone">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" style="width: 16px">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                        </svg>

                        <span class="text-phone">
                            {{ \Illuminate\Support\Str::mask($car->phone, '*', -3) }}
                        </span>
                        <span class="car-details-phone-view" data-url="{{ route('car.showPhone', $car) }}"
                            style="    display: flex;justify-content: center;
    align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
