<!-- Find a car form -->
<section class="find-a-car">
  <div class="container">
    <form action="{{ route('car.search') }}" method="GET" class="find-a-car-form card flex p-medium">
      <div class="find-a-car-inputs">
        <div>
          <x-select-maker />
        </div>
        <div>
          <x-select-model />
        </div>
        <div>
          <x-select-state />
        </div>
        <div>
          <x-select-city />
        </div>
        <div>
          <x-select-car-type />
        </div>
        <div>
          <input type="number" placeholder="Year From" name="year_from" />
        </div>
        <div>
          <input type="number" placeholder="Year To" name="year_to" />
        </div>
        <div>
          <input type="number" placeholder="Price From" name="price_from" />
        </div>
        <div>
          <input type="number" placeholder="Price To" name="price_to" />
        </div>
        <div>
          <x-select-fuel-type />
        </div>
      </div>
      <div>
        <button type="button" class="btn btn-find-a-car-reset">
          Réinitialiser
        </button>
        <button class="btn btn-primary btn-find-a-car-submit">
          Rechercher
        </button>
      </div>
    </form>
  </div>
</section>
<!--/ Find a car form -->
