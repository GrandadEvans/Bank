<?php

namespace Bank\Http\Controllers;

use Bank\Http\Requests\RegularRequest;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\Regular;
use Exception;
use http\Exception\UnexpectedValueException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Throwable;

/**
 * Regular Transaction Controller
 */
class RegularController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
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
     * @return View
     */
    public function create(): View
    {
        return view('regulars.create')
            ->with('providers', Provider::all()->get());
    }

    /**
     * @param  RegularRequest  $request
     *
     * @return Response
     * @throws Throwable
     */
    public function storeFromJs(RegularRequest $request): Response
    {
        try {
            $regular = $this->store($request);
        } catch (Exception $error) {
            // @todo log error
            return response($error->getMessage(), 403);
        }

        $user = Auth::user();

        return response([
            'regular' => $regular,
            'user' => $user
        ], 201);
    }

    /**
     * @param  RegularRequest  $request
     * @return RedirectResponse|Redirector
     * @throws Throwable
     */
    public function storeFromPhp(RegularRequest $request): Redirector|RedirectResponse
    {
        $flashDetails = [
            'type' => 'success',
            'title' => 'Success!',
            'text' => 'Item successfully created'
        ];

        try {
            $this->store($request);
        } catch (Exception $error) {
            $flashDetails = [
                'type' => 'error',
                'title' => 'Error!',
                'text' => 'There was an error saving the details you provided, please try again later or get in touch'
                    . $error->getMessage()
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
     * @throws Throwable
     * @todo    Handle the exception better
     */
    public function store(RegularRequest $request): Regular
    {
        $validated = $request->validated();

        $regular = new Regular($validated);
        $regular->user_id = Auth::id();

        try {
            $regular->saveOrFail();
        } catch (Exception $error) {
            $errorMessage = "We were not able to save the details you provided. Please try again, or contact us,\n"
                .$error->getMessage();

            throw new UnexpectedValueException($errorMessage);
        }

        return $regular;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Regular  $regular
     * @return View
     */
    public function edit(Regular $regular): View
    {
        $regular->verifyRecordOwnership();

        return view('regulars.edit')
            ->with('regular', $regular)
            ->with('providers', Provider::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RegularRequest  $request
     * @param  Regular  $regular
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Throwable
     */
    public function update(RegularRequest $request, Regular $regular): Redirector|RedirectResponse|Application
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
     *
     * @return Application|Redirector|RedirectResponse
     * @throws Exception
     */
    public function destroy(Regular $regular): Application|RedirectResponse|Redirector
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
