<?php

namespace App\View\Components;

use App\Models\CarType;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class RadioListCarType extends Component
{
    public Collection $types;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->types = CarType::orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.radio-list-car-type');
    }
}
