<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $title = ''
    ) {
        if ($this->title) {
            $this->title = $this->title.' | '.config('app.name');
        } else {
            $this->title = config('app.name');
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.app');
    }
}
