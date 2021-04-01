<?php

namespace App\View\Components\SearchTask;

use Illuminate\View\Component;
use App\View\Components\SearchTask\View;

class Edit extends View
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($task)
    {
        parent::__construct($task);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.search-task.edit');
    }
}
