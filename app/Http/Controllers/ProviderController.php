<?php

namespace Bank\Http\Controllers;

use Bank\Http\Requests\ProviderRequest;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\Tag;
use Bank\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $statusCode = Response::HTTP_CREATED;

        try {
            $validated = $request->validated();

            if (isset($validated['provider_id']) && $validated['provider_id'] > 0) {
                $provider = Provider::findOrFail($validated['provider_id']);
            } else {
                $provider = $this->createNewProvider($validated);
            }

            $transaction = Transaction::findOrFail($validated['transaction_id']);
            $transaction->provider_id = $provider->id;
            $transaction->save();

            $similarTransactions = [];
            if ($validated['find_similar'] == 1) {
                $entryText = $transaction->entry;
                $similarTransactions = Transaction::where('entry', $entryText)->
                    where('id', '!=', $validated['transaction_id'])->
                    get();
            }

             $reply = [
                'provider_id' => $provider->id,
                'provider_name' => $provider->name,
                'similar_transactions' => $similarTransactions
            ];
      }
        catch(\Exception $e) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            $reply = $e->getMessage();
        }
        return new Response($reply, $statusCode);
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

    private function createNewProvider(array $validated)
    {
        $provider = new Provider();
        $provider->name = $validated['name'];
        $provider->remarks = $validated['remarks'];
        $provider->regular_expressions = $validated['regular_expressions'];
        $provider->payment_method_id = $validated['payment_method_id'];
        $provider->saveOrFail();

        return $provider;
    }

    public function assignTransactions(Request $request)
    {
        $assignedTransactions = [];
        $errors = [];
        $failedTransactions = [];
        $providerDetails = [];
        $providerId = intval($request->get('entity'));
        $responseCode = Response::HTTP_ACCEPTED;
        $transactions = $request->get('transactions');

        try {
            $provider = Provider::findOrFail($providerId);
            $providerDetails = [
                'name' => $provider->provider,
                'id' => $provider->id
            ];
        }
        catch(\Exception $e) {
            $errors[] = [
                'action' => 'find provider',
                'error' => $e->getMessage(),
                'providerId' => $providerId
            ];
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        $entityDetails = [];
        if ($responseCode !== Response::HTTP_BAD_REQUEST) {
            $sanitized = [];
            foreach ($transactions as $transaction) {
                if (intval($transaction) !== 0) {
                    $sanitized[] = intval($transaction); // @todo do I really need this twice
                }
            }
            $sanitized = array_unique($sanitized);

            $entityDetails = Transaction::whereIn('id', $sanitized)
                ->update(['provider_id' => $providerId]);
        }

        $responseText = [
            'errors' => $errors,
            'failedTransactions' => $failedTransactions,
            'assignedTransactions' => $assignedTransactions,
            'entityDetails' => $entityDetails
        ];
        return new Response($responseText, $responseCode);
    }
}
