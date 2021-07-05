<?php

namespace Bank\Http\Controllers;

use Bank\Http\Requests\ProviderRequest;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // If the regular expression has changed then format the correct flash data here
//        Swal.fire({
//  title: 'Are you sure?',
//  text: "You won't be able to revert this!",
//  icon: 'warning',
//  showCancelButton: true,
//  confirmButtonColor: '#3085d6',
//  cancelButtonColor: '#d33',
//  confirmButtonText: 'Yes, delete it!'
//}).then((result) => {
//        if (result.isConfirmed) {
//            Swal.fire(
//                'Deleted!',
//                'Your file has been deleted.',
//                'success'
//            )
//  }
//    })
       if (session()->has('hasUpdatedRegularExpressions')) {
            $flashData = [
                'type' => 'question',
                'title' => 'New regex found!',
                'text' => 'Do you want to run the new regular expression against the transactions now?',
                'showConfirmButton' => 'true',
                'showCancelButton' => 'true',
                'cancelButtonText' => '<i class="fa fa-thumbs-down" />No',
                'confirmButtonText' =>
                    '<a href="/transactions/filter/' . session()->get('updatedProviderRegex') .'"'.
                    'style="text-decoration: none; color: white;"><i class="fa fa-thumbs-up" />Yes</a>'
            ];

            session()->flash('alert', $flashData);

            // Remove the changed regex trigger from the flash store
            session()->remove('hasUpdatedRegularExpressions');
        }

        return view('providers.index')
            ->with('providers', Provider::all()->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        session()->remove('hasUpdatedRegularExpressions');

        return view('providers.create')
            ->with('paymentMethods', PaymentMethod::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(ProviderRequest $request)
    {
        $validated = $request->validated();

        $provider = new Provider($validated);
        $provider->saveOrFail();

        $flashData = [
            'type' => 'success',
            'title' => 'Success!',
            'text' => 'Provider successfully created'
        ];

        session()->flash('alert', $flashData);



        session()->remove('hasUpdatedRegularExpressions');
        return view('providers.create')
            ->with('paymentMethods', PaymentMethod::all());
//        return redirect(route('providers.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProviderRequest $request
     * @return Response
     * @throws Throwable
     */
    public function storeFromJs(ProviderRequest $request)
    {
        $validated = $request->validated();
        $responseText = 'OK';
        $responseCode = Response::HTTP_CREATED;

        try {
            $provider = new Provider($validated);
            $provider->saveOrFail();

            $transaction = Transaction::findOrFail($validated['transaction_id']);
            $transaction->provider_id = $provider->id;
            $transaction->save();
        }
        catch (\Exception $e) {
            $responseText = $e->getMessage();
            $responseCode = Response::HTTP_BAD_REQUEST;
        }
        return new Response($responseText, $responseCode);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Bank\Provider  $provider
     * @return Response
     */
    public function show(Provider $provider)
    {
        //        session()->remove('hasUpdatedRegularExpressions');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Bank\Provider  $provider
     * @return Response
     */
    public function edit(Provider $provider)
    {
        session()->remove('hasUpdatedRegularExpressions');
        return view('providers.edit')
            ->with('provider', $provider)
            ->with('paymentMethods', PaymentMethod::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \Bank\Provider  $provider
     * @return Response
     */
    public function update(ProviderRequest $request, Provider $provider)
    {
        $validated = $request->validated();
        $provider->update($validated);
        $provider->saveOrFail();

        session()->put([
            'updatedProviderId' => $provider->id,
            'updatedProviderName' => $provider->name,
           'updatedProviderRegex' => $provider->regular_expressions
           ]);

        return redirect(route('providers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Bank\Provider  $provider
     * @return Response
     */
    public function destroy(Provider $provider)
    {
        $provider->delete();
        $flashData = [
            'type' => 'success',
            'title' => 'Success!',
            'text' => 'Provider successfully deleted'
        ];

        session()->flash('alert', $flashData);
        session()->remove('hasUpdatedRegularExpressions');

        return redirect(route('providers.index'));
    }

    public function findTransactions(Provider $provider)
    {
        return view('providers.transactions')
            ->with('provider', $provider);
    }

    public function simple_list()
    {
        return Provider::all()->get();
    }
}
