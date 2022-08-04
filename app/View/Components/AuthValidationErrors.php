<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AuthValidationErrors extends Component
{
    public $errors;
    public function __construct($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.auth-validation-errors');
    }
}
