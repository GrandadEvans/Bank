<?php

namespace Bank\Http\Controllers;

use Bank\Http\Requests\ProviderRequest;
use Bank\Models\PaymentMethod;
use Bank\Models\Provider;
use Bank\Models\Transaction;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

/**
 * Provider Controller
 */
class ProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function index(): Application|Factory|View
    {
        if (session()->has('hasUpdatedRegularExpressions')) {
            $flashData = [
                'type' => 'question',
                'title' => 'New regex found!',
                'text' => 'Do you want to run the new regular expression against the transactions now?',
                'showConfirmButton' => 'true',
                'showCancelButton' => 'true',
                'cancelButtonText' => '<font-awesome-icon icon="fa-solid fa-thumbs-down" />No',
                'confirmButtonText' => '<a href="/transactions/filter/' . session()->get('updatedProviderRegex') . '"'
                    . 'style="text-decoration: none; color: white;">'
                    . '<font-awesome-icon icon="fa-solid fa-thumbs-up" />Yes</a>'
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
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        session()->remove('hasUpdatedRegularExpressions');

        return view('providers.create')
            ->with('paymentMethods', PaymentMethod::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ProviderRequest  $request
     *
     * @return Application|Factory|View
     * @throws Throwable
     */
    public function store(ProviderRequest $request): Application|Factory|View
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProviderRequest $request
     * @return Response
     * @throws Throwable
     */
    public function storeFromJs(ProviderRequest $request): Response
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
        } catch (Exception $e) {
            $statusCode = Response::HTTP_BAD_REQUEST;
            $reply = $e->getMessage();
        }
        return new Response($reply, $statusCode);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Provider $provider
     *
     * @return Application|Factory|View
     */
    public function edit(Provider $provider): Application|Factory|View
    {
        session()->remove('hasUpdatedRegularExpressions');

        return view('providers.edit')
            ->with('provider', $provider)
            ->with('paymentMethods', PaymentMethod::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ProviderRequest  $request
     * @param  Provider  $provider
     *
     * @return RedirectResponse|Redirector|Application
     * @throws Throwable
     */
    public function update(ProviderRequest $request, Provider $provider): Application|RedirectResponse|Redirector
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
     * @param  Provider $provider
     *
     * @return RedirectResponse|Redirector|Application
     */
    public function destroy(Provider $provider): Application|RedirectResponse|Redirector
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

    /**
     * @param  Provider  $provider
     *
     * @return Application|Factory|View
     */
    public function findTransactions(Provider $provider): View|Factory|Application
    {
        return view('providers.transactions')
            ->with('provider', $provider);
    }

    /**
     * Return a collection of all the providers
     *
     * @return Collection
     */
    public function simpleList(): Collection
    {
        return Provider::all()->get();
    }

    /**
     * @param  array  $validated
     *
     * @return Provider
     * @throws Throwable
     */
    private function createNewProvider(array $validated): Provider
    {
        $provider = new Provider();
        $provider->name = $validated['name'];
        $provider->remarks = $validated['remarks'];
        $provider->regular_expressions = $validated['regular_expressions'];
        $provider->payment_method_id = $validated['payment_method_id'];
        $provider->saveOrFail();

        return $provider;
    }

    /**
     * @param  Request  $request
     *
     * @return Response
     */
    public function assignTransactions(Request $request): Response
    {
        $assignedTransactions = [];
        $errors = [];
        $entityDetails = [];
        $failedTransactions = [];
        $providerId = intval($request->get('entity'));
        $responseCode = Response::HTTP_ACCEPTED;
        $transactions = $request->get('transactions');

        try {
            $provider = Provider::findOrFail($providerId);
            $entityDetails = [
                'name' => $provider->name,
                'id' => $provider->id
            ];
        } catch (Exception $e) {
            $errors[] = [
                'action' => 'find provider',
                'error' => $e->getMessage(),
                'providerId' => $providerId
            ];
            $responseCode = Response::HTTP_BAD_REQUEST;
        }

        if ($responseCode !== Response::HTTP_BAD_REQUEST) {
            $sanitized = [];
            foreach ($transactions as $transaction) {
                if (intval($transaction) !== 0) {
                    $sanitized[] = intval($transaction); // @todo do I really need this twice
                }
            }
            $sanitized = array_unique($sanitized);

            Transaction::whereIn('id', $sanitized)->update(['provider_id' => $providerId]);

            $transactions = Transaction::whereIn('id', $sanitized)->get();

            foreach ($transactions as $transaction) {
                if ($transaction->provider_id === $providerId) {
                    $assignedTransactions[] = $transaction->id;
                } else {
                    $failedTransactions[] = $transaction->id;
                }
            }
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
