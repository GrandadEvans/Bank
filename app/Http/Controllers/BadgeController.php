<?php

namespace Bank\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Badge Controller
 */
class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): string
    {
        return json_encode(Auth::user()->badges);
    }
}
