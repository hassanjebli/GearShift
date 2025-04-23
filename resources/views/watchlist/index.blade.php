<x-app-layout>

  <main>
    <!-- Voitures neuves -->
    <section>
      <div class="container">
        <div class="flex justify-between items-center">
          <h2>Mes voitures favorites</h2>
          @if ($cars->total() > 0)
            <div class="pagination-summary">
              <p>
                Affichage de {{ $cars->firstItem() }} à
                {{ $cars->lastItem() }} sur {{ $cars->total() }} résultats
              </p>
            </div>
          @endif
        </div>
        <div class="car-items-listing">
          @foreach ($cars as $car)
            <x-car-item :$car :isInWatchlist="true" />
          @endforeach
        </div>

        @if ($cars->count() === 0)
          <div class="text-center p-large">
            Vous n'avez aucune voiture favorite.
          </div>
        @endif

        {{ $cars->onEachSide(1)->links() }}
      </div>
    </section>
    <!--/ Voitures neuves -->
  </main>
</x-app-layout>
