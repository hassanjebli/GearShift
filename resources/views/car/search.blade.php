<x-app-layout>
  <main>
    <!-- Found Cars -->
    <section>
      <div class="container">
        <div class="sm:flex items-center justify-between mb-medium">
          <div class="flex items-center">
            <button class="show-filters-button flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" style="width: 20px">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 13.5V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m12-3V3.75m0 9.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 3.75V16.5m-6-9V3.75m0 3.75a1.5 1.5 0 0 1 0 3m0-3a1.5 1.5 0 0 0 0 3m0 9.75V10.5" />
              </svg>
              Filtres
            </button>

            <h2>Définissez vos critères de recherche</h2>
          </div>

          <select class="sort-dropdown">
            <option value="">Trier par</option>
            <option value="price">Prix croissant</option>
            <option value="-price">Prix décroissant</option>
            <option value="year">Année croissante</option>
            <option value="-year">Année décroissante</option>
            <option value="mileage">Kilométrage croissant</option>
            <option value="-mileage">Kilométrage décroissant</option>
            <option value="published_at">Le plus récent en haut</option>
            <option value="-published_at">Le plus ancien en haut</option>
          </select>
        </div>
        <div class="search-car-results-wrapper">
          <div class="search-cars-sidebar">
            <div class="card card-found-cars">
              <p class="m-0">Trouvé <strong>{{ $cars->total() }}</strong> cars</p>

              <button class="close-filters-button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 24px">
                  <path fill-rule="evenodd"
                    d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                    clip-rule="evenodd" />
                </svg>
              </button>
            </div>

            <!-- Find a car form -->
            <section class="find-a-car">
              <form action="" method="GET" class="find-a-car-form card flex p-medium">
                <div class="find-a-car-inputs">
                  <div class="form-group">
                    <label class="mb-medium">Marque</label>
                    <x-select-maker :value="request('maker_id')" />
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Modèle</label>
                    <x-select-model :value="request('model_id')" />
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Type</label>
                    <x-select-car-type :value="request('car_type_id')" />
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Année</label>
                    <div class="flex gap-1">
                      <input type="number" placeholder="Année De" name="year_from"
                        value="{{ request('year_from') }}" />
                      <input type="number" placeholder="Année À" name="year_to" value="{{ request('year_to') }}" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Prix</label>
                    <div class="flex gap-1">
                      <input type="number" placeholder="Prix De" name="price_from"
                        value="{{ request('price_from') }}" />
                      <input type="number" placeholder="Prix À" name="price_to" value="{{ request('price_to') }}" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Kilométrage</label>
                    <div class="flex gap-1">
                      <x-select-mileage :value="request('mileage')" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">État</label>
                    <x-select-state :value="request('state_id')" />
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Ville</label>
                    <x-select-city :value="request('city_id')" />
                  </div>
                  <div class="form-group">
                    <label class="mb-medium">Type de carburant</label>
                    <x-select-fuel-type :value="request('fuel_type_id')" />
                  </div>
                </div>
                <div class="flex">
                  <button type="button" class="btn btn-find-a-car-reset">
                    Réinitialiser
                  </button>
                  <button class="btn btn-primary btn-find-a-car-submit">
                    Rechercher
                  </button>
                </div>
              </form>

            </section>
            <!--/ Find a car form -->
          </div>

          <div class="search-cars-results">
            <div class="car-items-listing">
              @foreach ($cars as $car)
                <x-car-item :$car :is-in-watchlist="$car->favouredUsers->contains(\Illuminate\Support\Facades\Auth::user())" />
              @endforeach
            </div>
            {{ $cars->onEachSide(1)->links('pagination') }}
          </div>
        </div>
      </div>
    </section>
    <!--/ Found Cars -->
  </main>
</x-app-layout>
