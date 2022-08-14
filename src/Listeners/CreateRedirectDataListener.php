<?php

namespace PavelZanek\RedirectionsLaravel\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use PavelZanek\RedirectionsLaravel\Events\RedirectWasUsedEvent;

class CreateRedirectDataListener implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param  \PavelZanek\RedirectionsLaravel\Events\RedirectWasUsedEvent $event
     * @return void
     */
    public function handle(RedirectWasUsedEvent $event)
    {
        $event->redirect->redirectData()->create([
            'used_at' => now()
        ]);
    }
}
