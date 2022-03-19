<?php

namespace Bank\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\View;
use stdClass;

/**
 * Prediction Strategy Controller
 */
class PredictionsController extends Controller
{

    /**
     * Show the predictions page.
     *
     * @return View
     */
    public function index(): View
    {
        return view('predictions')->with('predictions', (new stdClass([
            'amount'  => '50',
            'balance' => '50',
            'date'    => '2019-12-25',
            'entry'   => 'Town Shopping',
            'remarks' => 'Town Shopping',
            'type'    => 'dd',
        ])));
    }
}
