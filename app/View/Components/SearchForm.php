<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search-form');
    }

    /*
     * Do not use these public properties or methods.
     * - data
     * - render
     * - resolveView
     * - shouldRender
     * - view
     * - withAttributes
     * - withName
     */
}
