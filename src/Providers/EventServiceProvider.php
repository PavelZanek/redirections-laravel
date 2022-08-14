<?php

namespace PavelZanek\RedirectionsLaravel\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use PavelZanek\RedirectionsLaravel\Events\RedirectWasUsedEvent;
use PavelZanek\RedirectionsLaravel\Listeners\CreateRedirectDataListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RedirectWasUsedEvent::class => [
            CreateRedirectDataListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}