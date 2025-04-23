<x-app-layout bodyClass="page-my-cars">
  <main>
    <div>
      <div class="container">
        <h1 class="car-details-page-title">
          Gérer les images pour {{ $car->getTitle() }}
        </h1>
        <div class="car-images-wrapper">
          <form action="{{ route('car.updateImages', $car) }}" method="POST" class="card p-medium form-update-images">
            @csrf
            @method('PUT')

            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Supprimer</th>
                    <th>Image</th>
                    <th>Position</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($car->images as $image)
                    <tr>
                      <td>
                        <input type="checkbox" name="delete_images[]" id="delete_image_{{ $image->id }}"
                          value="{{ $image->id }}">
                      </td>
                      <td>
                        <img src="{{ $image->getUrl() }}" alt="" class="my-cars-img-thumbnail" />
                      </td>
                      <td>
                        <input type="number" name="positions[{{ $image->id }}]"
                          value="{{ old('positions.' . $image->id, $image->position) }}">
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="3" class="text-center p-large">
                        Il n'y a pas d'images
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="p-medium">
              <div class="flex justify-end">
                <button class="btn btn-primary">Mettre à jour les images</button>
              </div>
            </div>
          </form>

          <form action="{{ route('car.addImages', $car) }}" enctype="multipart/form-data" method="POST"
            class="card form-images p-medium mb-large">
            @csrf
            <div class="form-image-upload">
              <div class="upload-placeholder">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" style="width: 48px">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
              </div>
              <input id="carFormImageUpload" type="file" name="images[]" multiple />
            </div>
            <div id="imagePreviews" class="car-form-images"></div>

            <div class="p-medium">
              <div class="flex justify-end">
                <button class="btn btn-primary">Ajouter des images</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
</x-app-layout>
