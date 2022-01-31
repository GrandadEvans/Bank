<?php

namespace Bank\View\Components;

use Illuminate\View\Component;

class badgeComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return <<<'blade'
<div>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
</div>
blade;
    }
}
