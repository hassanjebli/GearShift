<x-app-layout title="Home Page">
  <!-- Home Slider -->
  <section class="hero-slider">
    <!-- Carousel wrapper -->
    <div class="hero-slides">
      <!-- Item 1 -->
      <div class="hero-slide">
        <div class="container">
          <div class="slide-content">
            <h1 class="hero-slider-title">
              Achetez <strong>Les Meilleures Voitures</strong> <br />
              dans votre région
            </h1>
            <div class="hero-slider-content">
              <p>
                Utilisez un puissant outil de recherche pour trouver les voitures
                souhaitées en fonction de plusieurs critères de recherche : Marque,
                Modèle, Année, Plage de prix, Type de voiture, etc...
              </p>

              <a href="{{ route('car.search') }}" class="btn btn-hero-slider">Trouvez la voiture</a>
            </div>
          </div>

          <div class="slide-image">
            <img src="/img/car-png.png" alt="" class="img-responsive" />
          </div>
        </div>
      </div>
      <!-- Item 2 -->
      <div class="hero-slide">
        <div class="flex container">
          <div class="slide-content">
            <h2 class="hero-slider-title">
              Vous voulez <br />
              <strong>vendre votre voiture ?</strong>
            </h2>
            <div class="hero-slider-content">
              <p>
                Soumettez votre voiture dans notre interface conviviale, décrivez-la,
                téléchargez des photos et l'acheteur parfait la trouvera...
              </p>

              <a href="{{ route('car.create') }}" class="btn btn-hero-slider">Ajouter votre voiture</a>
            </div>
          </div>

          <div class="slide-image">
            <img src="/img/car-png.png" alt="" class="img-responsive" />
          </div>
        </div>
      </div>
      <button type="button" class="hero-slide-prev">
        <svg style="width: 18px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M5 1 1 5l4 4" />
        </svg>
        <span class="sr-only">Précédent</span>
      </button>
      <button type="button" class="hero-slide-next">
        <svg style="width: 18px" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 6 10">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 9 4-4-4-4" />
        </svg>
        <span class="sr-only">Suivant</span>
      </button>
    </div>
  </section>
  <!--/ Home Slider -->
  <main>
    <x-search-form />
    <!-- New Cars -->
    <section>
      <div class="container">
        <h2>Dernières Voitures Ajoutées</h2>
        @if ($cars->count() > 0)
          <div class="car-items-listing">
            @foreach ($cars as $car)
              <x-car-item :$car :is-in-watchlist="$car->favouredUsers->contains(\Illuminate\Support\Facades\Auth::user())" />
            @endforeach
          </div>
        @else
          <div class="text-center p-large">
            Il n'y a pas de voitures publiées.
          </div>
        @endif
      </div>
    </section>

    <!--/ New Cars -->
  </main>
</x-app-layout>
