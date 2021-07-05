<?php

namespace Bank\Http\Controllers;

use stdClass;

class PredictionsController extends Controller
{

    /**
     * Show the predictions page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('predictions')->with('predictions', (new stdClass([
            'date' =>'2019-12-25',
            'entry' => 'Town Shopping',
            'remarks' => 'Town Shopping',
            'amount' => '50',
            'balance' => '50',
            'type' => 'dd'
        ])));
    }
}
