<?php

namespace Bank\Http\Controllers;

use Illuminate\View\View;

/**
 * Just here for the Welcome page
 */
class WelcomeController extends Controller
{
    /**
     * Show the welcome Vue component
     *
     * @return View
     */
    public function welcome(): View
    {
        return view('welcome');
    }
}
