<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarFeatures;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\Maker;
use App\Models\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
//        $user = $request->session()->get('user', 'John'); // Get data for "user" key from session
//        $all = $request->session()->all();
//        dd($all);
//        $user2 = session('user', 'John');  // Get data for "user" key from session

//        $request->session()->put('user', 'Hassan'); // Put data for "user" key from session
//        session(['user' => 'Hassan']);

//        $request->session()->forget('user');
//        $user = $request->session()->remove('user');

        $cars = Cache::remember('home-cars', 60, function() {
            return Car::where('published_at', '<', now())
                ->with(['primaryImage', 'city', 'carType', 'fuelType',
                    'maker', 'model', 'favouredUsers'])
                ->orderBy('published_at', 'desc')
                ->limit(30)
                ->get();
        });

        return view('home.index', ['cars' => $cars]);
    }
}
