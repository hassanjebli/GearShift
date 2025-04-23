<?php

namespace App\View\Components;

use App\Models\State;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class SelectState extends Component
{
    public Collection $states;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->states = Cache::rememberForever('states', function() {
            return State::orderBy('name')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-state');
    }
}
