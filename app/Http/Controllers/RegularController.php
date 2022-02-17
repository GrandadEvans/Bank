<?php

namespace Bank\Http\Controllers;

use Bank\Http\Requests\RegularRequest;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\Regular;
use Exception;
use http\Exception\UnexpectedValueException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $all = Regular::myRecords()->get();
        return view('regulars.index')
            ->with('transactions', Regular::myRecords()->with('provider:id,name')->get())
            ->with('total', array_sum($all->pluck('amount')->toArray()))
            ->with('payment_method', PaymentMethod::list())
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

    public function storeFromJs(RegularRequest $request)
    {
        $flashDetails = [
            'type' => 'success',
            'title' => 'Success!',
            'text' => 'Item successfully created'
        ];

        try {
            $regular = $this->store($request);
        } catch (Exception $e) {
            // @todo log error
            return response([], 403);
        }

        $user = Auth::user();

        return response([
            'regular' => $regular,
            'user' => $user
        ], 201);
    }

    public function storeFromPhp(RegularRequest $request)
    {
        $flashDetails = [
            'type' => 'success',
            'title' => 'Success!',
            'text' => 'Item successfully created'
        ];

        try {
            $regular = $this->store($request);
        } catch (Exception $e) {
            $flashDetails = [
                'type' => 'error',
                'title' => 'Error!',
                'text' => 'There was an error saving the details you provided, please try again later or get in touch'
            ];
        }
        return redirect(route('regulars.index'))
            ->with('flashMessage', $flashDetails);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RegularRequest  $request
     * @return Regular
     * @throws \Throwable
     * @todo    Handle the exception better
     *
     */
    public function store(RegularRequest $request): Regular
    {
        $validated = $request->validated();

        $regular = new Regular($validated);
        $regular->user_id = Auth::id();

        try {
            $regular->saveOrFail();
        } catch (Exception $e) {
            throw new UnexpectedValueException('We were not able to save the details you provided. Please try again, or contact us,');
        }

        return $regular;
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

}
