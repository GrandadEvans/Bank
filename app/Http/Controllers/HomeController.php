<?php

namespace Bank\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * This really just controls the Home Page
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Import the latest transactions or get them from the bank
     *
     * @return Factory|View
     */
    public function import(): Factory|View
    {
        return view('transactions.import');
    }
}
