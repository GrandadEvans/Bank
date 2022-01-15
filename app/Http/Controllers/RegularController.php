<?php

namespace Bank\Http\Controllers;

use Bank\Http\Requests\RegularRequest;
use Bank\Models\PaymentMethod;
use Bank\Models\Regular;
use Bank\Models\Provider;
use Bank\Events\ScanForRegulars;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $all = Regular::myRecords()->get();
        return view('regulars.index')
            ->with('transactions', Regular::myRecords()->with('provider:id,name')->get())
            ->with('total', array_sum($all->pluck('amount')->toArray()))
            ->with('payment_methods', PaymentMethod::list())
            ->with('providers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('regulars.create')
            ->with('providers', Provider::all()->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RegularRequest  $request
     *
     * @return Response
     * @throws \Throwable
     */
    public function store(RegularRequest $request)
    {
        $validated = $request->validated();

        $regular = new Regular($validated);
        $regular->user_id = Auth::id();
        $regular->saveOrFail();

        return redirect(route('regulars.index'))
            ->with('flashMessage', [
                'type' => 'success',
                'title' => 'Success!',
                'text' => 'Item successfully created'
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Regular  $regular
     * @return Response
     */
    public function edit(Regular $regular)
    {
        $regular->verifyRecordOwnership();

        return view('regulars.edit')
            ->with('regular', $regular)
            ->with('providers', Provider::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Regular  $regular
     * @return Response
     * @throws \Throwable
     */
    public function update(RegularRequest $request, Regular $regular)
    {
        $regular->verifyRecordOwnership();

        $validated = $request->validated();
        $regular->update($validated);
        $regular->saveOrFail();

        return redirect(route('regulars.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Regular  $regular
     * @return Response
     * @throws Exception
     */
    public function destroy(Regular $regular)
    {
        $regular->delete();
        return redirect(route('regulars.index'))
            ->with('flashMessage', [
                'type' => 'success',
                'title' => 'Success!',
                'text' => 'Item successfully deleted'
            ]);

    }

    /**
     * Manually request a new scan of new regulars
     */
    public function scan() {
        ScanForRegulars::dispatch();
    }
}
