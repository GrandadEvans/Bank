<?php

namespace Bank\Providers;

use Illuminate\Auth\Events\Registered;
use Bank\Events\ScanForRegulars;
use Bank\Listeners\StartNewRegularsScan;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ScanForRegulars::class => [
            StartNewRegularsScan::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
    Event::listen(function (QueueBusy $event) {
        Notification::route('mail', env('MAIL_ADMIN_ADDRESS', 'bank@localhost'))
                ->notify(new QueueHasLongWaitTime(
                    $event->connection,
                    $event->queue,
                    $event->size
                ));
    });
    }
}
