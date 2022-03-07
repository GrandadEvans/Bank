<?php

namespace Bank\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * Show the welcome Vue component
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome()
    {
        return view('welcome');
    }
}
