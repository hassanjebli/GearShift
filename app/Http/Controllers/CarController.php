<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller/* implements HasMiddleware*/
{
//    public static function middleware()
//    {
//        return [
//            // Add auth middleware to every routes
//            'auth',
//            // Add auth middleware to every route except show
//            new \Illuminate\Routing\Controllers\Middleware('auth', except: ['show']),
//            // Add closure type of middleware
//            function (Request $request, \Closure $next) {
//                $next();
//            }
//        ];
//    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cars = $request->user()
            ->cars()
            ->with(['primaryImage', 'maker', 'model'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('car.index', ['cars' => $cars]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create', Car::class)) {
            return redirect()->route('profile.index')
                ->with('warning', 'Please provide phone number');
        }
        return view('car.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarRequest $request)
    {
        if (!Gate::allows('create', Car::class)) {
            return redirect()->route('profile.index')
                ->with('warning', 'Please provide phone number');
        }

        // Get request data
        $data = $request->validated();

        // Get features data
        $featuresData = $data['features'];
        // Get images
        $images = $request->file('images') ?: [];

        // Set user ID
        $data['user_id'] = Auth::id();
        // Create new car
        $car = Car::create($data);

        // Create features
        $car->features()->create($featuresData);

        // Iterate and create images
        foreach ($images as $i => $image) {
            // Save image on file system
            $path = $image->store('public/images');
            // Create record in the database
            $car->images()->create(['image_path' => $path, 'position' => $i + 1]);
        }

        // Redirect to car.index route
        return redirect()->route('car.index')
            ->with('success', 'Car was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Car $car)
    {
        if (!$car->published_at) {
            abort(404);
        }
        return view('car.show', ['car' => $car]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        Gate::authorize('update', $car);

        return view('car.edit', ['car' => $car]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCarRequest $request, Car $car)
    {
        Gate::authorize('update', $car);

        // Get validated data from request
        $data = $request->validated();

        // Get features from the data
        $features = array_merge([
            'abs' => 0,
            'air_conditioning' => 0,
            'power_windows' => 0,
            'power_door_locks' => 0,
            'cruise_control' => 0,
            'bluetooth_connectivity' => 0,
            'remote_start' => 0,
            'gps_navigation' => 0,
            'heated_seats' => 0,
            'climate_control' => 0,
            'rear_parking_sensors' => 0,
            'leather_seats' => 0,
        ], $data['features'] ?? []);

        // Update car details
        $car->update($data);

        // Update Car features
        $car->features()->update($features);

//        $request->session()->flash('success', 'Car was updated');

        // Redirect user back to car listing page
        return redirect()->route('car.index')
            ->with('success', 'Car was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        Gate::authorize('delete', $car);

//        Gate::any(['update-car', 'delete-car'], $car);
//        Gate::none(['update-car', 'delete-car'], $car);
//        Gate::forUser($user)->denies()

        $car->delete();

        return redirect()->route('car.index')
            ->with('success', 'Car was deleted');
    }

    public function search(Request $request)
    {
        $maker = $request->integer('maker_id');
        $model = $request->integer('model_id');
        $carType = $request->integer('car_type_id');
        $fuelType = $request->integer('fuel_type_id');
        $state = $request->integer('state_id');
        $city = $request->integer('city_id');
        $yearFrom = $request->integer('year_from');
        $yearTo = $request->integer('year_to');
        $priceFrom = $request->integer('price_from');
        $priceTo = $request->integer('price_to');
        $mileage = $request->integer('mileage');
        $sort = $request->input('sort', '-published_at');

        $query = Car::where('published_at', '<', now())
            ->with(['primaryImage', 'city', 'carType', 'fuelType',
                'maker', 'model', 'favouredUsers']);

        if ($maker) {
            $query->where('maker_id', $maker);
        }
        if ($model) {
            $query->where('model_id', $model);
        }
        if ($state) {
            $query->join('cities', 'cities.id', '=', 'cars.city_id')
                ->where('cities.state_id', $state);
        }
        if ($city) {
            $query->where('city_id', $city);
        }
        if ($carType) {
            $query->where('car_type_id', $carType);
        }
        if ($fuelType) {
            $query->where('fuel_type_id', $fuelType);
        }
        if ($yearFrom) {
            $query->where('year', '>=', $yearFrom);
        }
        if ($yearTo) {
            $query->where('year', '<=', $yearTo);
        }
        if ($priceFrom) {
            $query->where('price', '>=', $priceFrom);
        }
        if ($priceTo) {
            $query->where('price', '<=', $priceTo);
        }
        if ($mileage) {
            $query->where('mileage', '<=', $mileage);
        }

        if (str_starts_with($sort, '-')) {
            $sort = substr($sort, 1);
            $query->orderBy($sort, 'desc');
        } else {
            $query->orderBy($sort);
        }

        $cars = $query->paginate(15)
            ->withQueryString();

        return view('car.search', ['cars' => $cars]);
    }

    public function carImages(Car $car)
    {
        Gate::authorize('update', $car);
        return view('car.images', ['car' => $car]);
    }

    public function updateImages(Request $request, Car $car)
    {
        Gate::authorize('update', $car);

        // Get Validated data of delete images and positions
        $data = $request->validate([
            'delete_images' => 'array',
            'delete_images.*' => 'integer',
            'positions' => 'array',
            'positions.*' => 'integer',
        ]);

        $deleteImages = $data['delete_images'] ?? [];
        $positions = $data['positions'] ?? [];

        // Select images to delete
        $imagesToDelete = $car->images()->whereIn('id', $deleteImages)->get();

        // Iterate over images to delete and delete them from file system
        foreach ($imagesToDelete as $image) {
            if (Storage::exists($image->image_path)) {
                Storage::delete($image->image_path);
            }
        }

        // Delete images from the database
        $car->images()->whereIn('id', $deleteImages)->delete();

        // Iterate over positions and update position for each image, by its ID
        foreach ($positions as $id => $position) {
            $car->images()->where('id', $id)->update(['position' => $position]);
        }

        // Redirect back to car.images route
        return redirect()->route('car.images', $car)
            ->with('success', 'Car images were updated');
    }

    public function addImages(Request $request, Car $car)
    {
        Gate::authorize('update', $car);

        // Get images from request
        $images = $request->file('images') ?? [];

        // Select max position of car images
        $position = $car->images()->max('position') ?? 0;
        foreach ($images as $image) {
            // Save it on the file system
            $path = $image->store('public/images');
            // Save it in the database
            $car->images()->create([
                'image_path' => $path,
                'position' => $position + 1
            ]);
            $position++;
        }

        return redirect()->route('car.images', $car)
            ->with('success', 'New images were added');
    }

//    public static function middleware()
//    {
//        return [
//            // Add auth middleware to every routes
//            'auth',
//            // Add auth middleware to every route except show
//            new \Illuminate\Routing\Controllers\Middleware('auth', except: ['show']),
//            // Add closure type of middleware
//            function (Request $request, \Closure $next) {
//                $next();
//            }
//        ];
//    }

    public function showPhone(Car $car)
    {
        return response()->json(['phone' => $car->phone]);
    }
}
