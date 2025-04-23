<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        $cars = Auth::user()
            ->favouriteCars()
            ->with(['primaryImage', 'city', 'carType', 'fuelType', 'maker', 'model'])
            ->paginate(15);

        return view('watchlist.index', ['cars' => $cars]);
    }

    public function storeDestroy(Car $car)
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check if the current car is already added into favourite cars
        $carExists = $user->favouriteCars()->where('car_id', $car->id)->exists();

        // Remove if it exists
        if ($carExists) {
            $user->favouriteCars()->detach($car);

            return response()->json([
                'added' => false,
                'message' => 'Car was removed from watchlist'
            ]);
        }

        // Add the car into favourite cars of the user
        $user->favouriteCars()->attach($car);
        return response()->json([
            'added' => true,
            'message' => 'Car was added to watchlist'
        ]);
    }
}
