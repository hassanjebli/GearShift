<?php

namespace App\View\Components;

use App\Models\City;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class SelectCity extends Component
{
    public Collection $cities;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->cities = Cache::rememberForever('cities', function() {
            return City::orderBy('name')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-city');
    }
}
