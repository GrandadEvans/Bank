<?php

namespace Bank\Observers;

use Bank\Models\Provider;
use Illuminate\Http\Client\Request;

class ProviderObserver
{
    /**
     * Handle the provider "saving" event.
     *
     * @param  \Bank\Models\Provider  $provider
     * @return void
     */
    public function saving(Provider $provider)
    {
//        dd(session()->get('hasUpdatedRegularExpressions'));
        $oldValue = $provider->getOriginal('regular_expressions');
        $newValue = $provider->getAttribute('regular_expressions');
        if ($oldValue !== $newValue) {
            // Offer to run the new regex on all transactions
            session()->flash('hasUpdatedRegularExpressions', $provider->getAttribute('id'));
        }
    }

    public function saved($provider)
    {
    }

    /**
     * Handle the provider "created" event.
     *
     * @param  \Bank\Models\Provider  $provider
     * @return void
     */
    public function created(Provider $provider)
    {
        //
    }

    /**
     * Handle the provider "updated" event.
     *
     * @param  \Bank\Models\Provider  $provider
     * @return void
     */
    public function updated(Provider $provider)
    {
        //
    }

    /**
     * Handle the provider "deleted" event.
     *
     * @param  \Bank\Models\Provider  $provider
     * @return void
     */
    public function deleted(Provider $provider)
    {
        //
    }

    /**
     * Handle the provider "restored" event.
     *
     * @param  \Bank\Models\Provider  $provider
     * @return void
     */
    public function restored(Provider $provider)
    {
        //
    }

    /**
     * Handle the provider "force deleted" event.
     *
     * @param  \Bank\Models\Provider  $provider
     * @return void
     */
    public function forceDeleted(Provider $provider)
    {
        //
    }
}
