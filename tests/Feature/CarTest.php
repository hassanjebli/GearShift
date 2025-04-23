<?php


use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

it('should not be possible to access car create page as guest user', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(route('car.create'));

//    $response->ddSession();
//    $response->ddHeaders();
//    $response->dd();

//    $response->dump();
//    $response->dumpHeaders();
//    $response->dumpSession();

    $response->assertRedirectToRoute('login');
    $response->assertStatus(302);
});

it('should be possible to access car create page as authenticated user', function () {
    $user = \App\Models\User::factory()->create();
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)
        ->get(route('car.create'));

    $response->assertOk()
        ->assertSee("Add new car");
});

it('should not be possible to access my cars page as guest user', function () {
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->get(route('car.index'));

    $response->assertRedirectToRoute('login');
});

it('should be possible to access my cars page as authenticated user', function () {
    $user = \App\Models\User::factory()->create();
    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)
        ->get(route('car.index'));

    $response->assertOk()
        ->assertSee("My Cars");
});

it('should not create car with empty data', function () {
    $this->seed();
    $user = \App\Models\User::factory()->create();

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)->post(route('car.store'), [
        'maker_id' => null,
        'model_id' => null,
        'year' => null,
        'price' => null,
        'vin' => null,
        'mileage' => null,
        'car_type_id' => null,
        'fuel_type_id' => null,
        'state_id' => null,
        'city_id' => null,
        'address' => null,
        'phone' => null,
        'description' => null,
        'published_at' => null,
    ]);
    $response->assertInvalid([
        'maker_id',
        'model_id',
        'year',
        'price',
        'vin',
        'mileage',
        'car_type_id',
        'fuel_type_id',
        'state_id',
        'city_id',
        'address',
        'phone',
    ]);
});

it('should not create car with invalid data', function () {
    $this->seed();
    $user = \App\Models\User::factory()->create();

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)->post(route('car.store'), [
        'maker_id' => 100,
        'model_id' => 100,
        'year' => 1800,
        'price' => -1000,
        'vin' => '123',
        'mileage' => -1000,
        'car_type_id' => 100,
        'fuel_type_id' => 100,
        'state_id' => 100,
        'city_id' => 100,
        'address' => '123',
        'phone' => '123',
    ]);
    $response->assertInvalid([
        'maker_id',
        'model_id',
        'year',
        'price',
        'vin',
        'mileage',
        'car_type_id',
        'fuel_type_id',
        'state_id',
        'city_id',
        'phone',
    ]);
});

it('should create car with valid data', function () {
    $this->seed();
    $countCars = \App\Models\Car::count();
    $countImages = \App\Models\CarImage::count();
    $user = \App\Models\User::factory()->create();

    $images = [
        UploadedFile::fake()->image('1.jpg'),
        UploadedFile::fake()->image('2.jpg'),
        UploadedFile::fake()->image('3.jpg'),
        UploadedFile::fake()->image('4.jpg'),
        UploadedFile::fake()->image('5.jpg'),
    ];

    $features = [
        'abs' => '1',
        'air_conditioning' => '1',
        'power_windows' => '1',
        'power_door_locks' => '1',
        'cruise_control' => '1',
        'bluetooth_connectivity' => '1',
    ];
    $carData = [
        'maker_id' => 1,
        'model_id' => 1,
        'year' => 2020,
        'price' => 10000,
        'vin' => '11111111111111111',
        'mileage' => 10000,
        'car_type_id' => 1,
        'fuel_type_id' => 1,
        'state_id' => 1,
        'city_id' => 1,
        'address' => '123',
        'phone' => '123456789',
        'features' => $features,
        'images' => $images
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)->post(route('car.store'), $carData);
    $response->assertRedirectToRoute('car.index')
        ->assertSessionHas('success');

    $lastCar = \App\Models\Car::latest('id')->first();
    $features['car_id'] = $lastCar->id;

    $carData['id'] = $lastCar->id;
    unset($carData['features']);
    unset($carData['images']);
    unset($carData['state_id']);

    $this->assertDatabaseCount('cars', $countCars + 1);
    $this->assertDatabaseCount('car_images', $countImages + count($images));
    $this->assertDatabaseCount('car_features', $countCars + 1);
    $this->assertDatabaseHas('cars', $carData);
    $this->assertDatabaseHas('car_features', $features);
});

it('should display update car page with correct data', function () {
    $this->seed();
    $user = \App\Models\User::first();
    $firstCar = $user->cars()->first();

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)->get(route('car.edit', $firstCar->id));

    $response->assertSee("Edit Car:");
    $response->assertSeeInOrder([
        '<select id="makerSelect" name="maker_id">',
        '<option value="' . $firstCar->maker_id . '"',
        'selected>' . $firstCar->maker->name . '</option>'
    ], false);

    $response->assertSeeInOrder([
        '<select id="modelSelect" name="model_id">',
        '<option value="' . $firstCar->model_id . '"',
        'selected>',
        $firstCar->model->name
    ], false);

    $response->assertSeeInOrder([
        '<select name="year">',
        '<option value="' . $firstCar->year . '"',
        'selected>' . $firstCar->year . '</option>',
    ], false);

    $response->assertSeeInOrder([
        '<input type="radio" name="car_type_id" value="' . $firstCar->car_type_id . '"',
        'checked/>',
        $firstCar->carType->name,
    ], false);

    $response->assertSeeInOrder([
        'name="price"',
        ' value="' . $firstCar->price . '"',
    ], false);

    $response->assertSeeInOrder([
        'name="vin"',
        ' value="' . $firstCar->vin . '"',
    ], false);

    $response->assertSeeInOrder([
        'name="mileage"',
        ' value="' . $firstCar->mileage . '"',
    ], false);

    $response->assertSeeInOrder([
        '<input type="radio" name="fuel_type_id" value="' . $firstCar->fuel_type_id . '"',
        'checked/>',
        $firstCar->fuelType->name,
    ], false);

    $response->assertSeeInOrder([
        '<select id="stateSelect" name="state_id">',
        '<option value="' . $firstCar->city->state_id . '"',
        'selected>',
        $firstCar->city->state->name
    ], false);

    $response->assertSeeInOrder([
        '<select id="citySelect" name="city_id">',
        '<option value="' . $firstCar->city_id . '"',
        'selected>',
        $firstCar->city->name
    ], false);

    $response->assertSeeInOrder([
        'name="address"',
        ' value="' . $firstCar->address . '"',
    ], false);

    $response->assertSeeInOrder([
        'name="phone"',
        ' value="' . $firstCar->phone . '"',
    ], false);

    $response->assertSeeInOrder([
        '<textarea',
        'name="description"',
        $firstCar->description . '</textarea>',
    ], false);

    $response->assertSeeInOrder([
        'name="published_at"',
        ' value="' . (new Carbon($firstCar->published_at))->format('Y-m-d') . '"',
    ], false);

});

it('should successfully update the car details', function () {
    $this->seed();
    $countCars = \App\Models\Car::count();
    $user = User::first();
    $firstCar = $user->cars()->first();

    $features = [
        'abs' => '1',
        'air_conditioning' => '1',
        'power_windows' => '1',
        'power_door_locks' => '1',
        'cruise_control' => '1',
        'bluetooth_connectivity' => '1',
    ];
    $carData = [
        'maker_id' => 1,
        'model_id' => 1,
        'year' => 2020,
        'price' => 10000,
        'vin' => '11111111111111111',
        'mileage' => 10000,
        'car_type_id' => 1,
        'fuel_type_id' => 1,
        'state_id' => 1,
        'city_id' => 1,
        'address' => '123',
        'phone' => '123456789',
        'features' => $features,
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)
        ->put(route('car.update', $firstCar), $carData);

    $response->assertRedirectToRoute('car.index')
        ->assertSessionHas('success');

    $carData['id'] = $firstCar->id;
    $features['car_id'] = $firstCar->id;
    unset($carData['features']);
    unset($carData['images']);
    unset($carData['state_id']);

    $this->assertDatabaseCount('cars', $countCars);
    $this->assertDatabaseHas('cars', $carData);
    $this->assertDatabaseCount('car_features', $countCars);
    $this->assertDatabaseHas('car_features', $features);
});

it('should successfully delete a car', function () {
    $this->seed();

    $countCars = \App\Models\Car::count();
    $user = User::first();
    $firstCar = $user->cars()->first();

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)
        ->delete(route('car.destroy', $firstCar));

    $response->assertRedirectToRoute('car.index')
        ->assertSessionHas('success');

    $this->assertDatabaseHas('cars', [
        'id' => $firstCar->id,
        'deleted_at' => now()
    ]);
});

it('should upload more images on the car', function () {
    $this->seed();
    $user = User::first();
    $firstCar = $user->cars()->first();
    $oldCount = $firstCar->images()->count();

    $images = [
        UploadedFile::fake()->image('1.jpg'),
        UploadedFile::fake()->image('2.jpg'),
        UploadedFile::fake()->image('3.jpg'),
        UploadedFile::fake()->image('4.jpg'),
        UploadedFile::fake()->image('5.jpg'),
    ];

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)
        ->post(route('car.addImages', $firstCar), [
            'images' => $images
        ]);

    $response->assertRedirectToRoute('car.images', $firstCar)
        ->assertSessionHas('success');

    $newCount = $firstCar->images()->count();

    $this->assertEquals($newCount, $oldCount + count($images));
});

it("should successfully delete images on the car", function() {
    $this->seed();
    $user = User::first();
    $firstCar = $user->cars()->first();
    $oldCount = $firstCar->images()->count();
    $ids = $firstCar->images()->limit(2)->pluck('id')->toArray();

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)
        ->put(route('car.updateImages', $firstCar), [
            'delete_images' => $ids
        ]);

    $response->assertRedirectToRoute('car.images', $firstCar)
        ->assertSessionHas('success');

    $newCount = $firstCar->images()->count();

    $this->assertEquals($newCount, $oldCount - 2);
});

it("should successfully update image positions", function() {
    $this->seed();
    $user = User::first();
    $firstCar = $user->cars()->first();
    $images = $firstCar->images()->reorder('position', 'desc')->get();

    $data = [];
    foreach ($images as $i => $image) {
        $data[$image->id] = $i + 1;
    }

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user)
        ->put(route('car.updateImages', $firstCar), [
            'positions' => $data
        ]);

    $response->assertRedirectToRoute('car.images', $firstCar)
        ->assertSessionHas('success');

    foreach ($data as $id => $position) {
        $this->assertDatabaseHas('car_images', [
            'id' => $id, 'position' => $position
        ]);
    }
});

it('should test the user can\'t access other user\'s car', function() {
    $this->seed();

    [$user1, $user2] = User::limit(2)->get();

    $car = $user1->cars()->first();

    /** @var \Illuminate\Testing\TestResponse $response */
    $response = $this->actingAs($user2)
        ->get(route('car.edit', $car));

    $response->assertStatus(404);
});
