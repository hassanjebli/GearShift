<?php

namespace App\View\Components;

use App\Models\Maker;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class SelectMaker extends Component
{
    public ?Collection $makers;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
//        $maker = \cache('key');
//        \cache(['key' => 'value'], -10);
//        $makers = \cache()->remember('makers', 10, function() {
//            return; // Select your makers
//        });

        // Put info in cache in default store
//        Cache::set('makers', 'test', 50);
//        Cache::put('makers', 'test', 5);
//        Cache::add('count', 0, now()->addMinutes(2));
//        Cache::increment('count', 2);

        // Put info in cache in file store
//        Cache::store('file')->set('makers', 'test', 5);
//
//        $data = Cache::get('makers');
//        dump($data);

        // Check
//        Cache::has('makers'); // true|false

//        Cache::forget('makers');
//        $makers = Cache::pull('makers');
//        Cache::put('makers', '', -1);
//        Cache::flush();

        $this->makers = Cache::rememberForever('makers', function() {
           return Maker::orderBy('name')->get();
        });
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select-maker');
    }
}
