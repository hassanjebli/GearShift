@props(['car', 'isInWatchlist' => false])

<div class="car-item card" style="border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.08); transition: transform 0.3s ease, box-shadow 0.3s ease; overflow: hidden; background-color: #ffffff; max-width: 400px; margin-bottom: 1.5rem;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 16px rgba(0,0,0,0.08)';">
  <a href="{{ route('car.show', $car) }}" style="display: block; position: relative; overflow: hidden; height: 220px;padding:8px">
    <img src="{{ $car->primaryImage?->getUrl() ?: '/img/no_image.jpg' }}" alt="{{ $car->getTitle() }}" class="car-item-img rounded-t" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease;border-radius: 8px;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1.0)';" />
  </a>
  <div class="p-medium" style="padding: 1.2rem 1.5rem;">
    <div class="flex items-center justify-between" style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
      <small class="m-0 text-muted" style="color: #6c757d;  display: flex; align-items: center;">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 14px; height: 14px; margin-right: 4px;">
          <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
        </svg>
        {{ $car->city->name }}
      </small>
      <button class="btn-heart text-primary" data-url="{{ route('watchlist.storeDestroy', $car) }}" style="background: none; border: none; cursor: pointer; padding: 5px; border-radius: 50%; transition: all 0.2s ease; outline: none; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.backgroundColor='rgba(255,0,0,0.1)';" onmouseout="this.style.backgroundColor='transparent';">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
          stroke="currentColor" style="width: 18px; height: 18px; color: #ff385c;" @class([
              'hidden' => $isInWatchlist,
          ])>
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" style="width: 18px; height: 18px; color: #ff385c;" @class([
              'hidden' => !$isInWatchlist,
          ])>
          <path
            d="m11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z" />
        </svg>
      </button>
    </div>
    <h2 class="car-item-title" style="margin: 0.5rem 0;  color: #212529; line-height: 1.3; word-wrap: break-word;">
      {{ $car->getTitle() }}
    </h2>
    <p class="car-item-price" style=" color: #0056b3; margin: 0.5rem 0 1rem;">${{ number_format($car->price, 0) }}</p>
    <hr style="margin: 0.8rem 0; border: 0; height: 1px; background-color: #eaeaea;" />
    <p class="m-0" style="display: flex; flex-wrap: wrap; gap: 6px; margin-top: 0.8rem;">
      <span class="car-item-badge" style="display: inline-block; padding: 4px 10px;  color: #505050; background-color: #f5f5f5; border-radius: 50px; line-height: 1.2;">{{ $car->carType->name }}</span>
      <span class="car-item-badge" style="display: inline-block; padding: 4px 10px;  color: #505050; background-color: #f5f5f5; border-radius: 50px; line-height: 1.2;">{{ $car->fuelType->name }}</span>
    </p>
  </div>
</div>