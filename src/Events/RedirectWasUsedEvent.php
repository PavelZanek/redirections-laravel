<?php

namespace PavelZanek\RedirectionsLaravel\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use PavelZanek\RedirectionsLaravel\Models\Redirect;

class RedirectWasUsedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The redirect instance.
     *
     * @var \PavelZanek\RedirectionsLaravel\Models\Redirect
     */
    public $redirect;
 
    /**
     * Create a new event instance.
     *
     * @param  \PavelZanek\RedirectionsLaravel\Models\Redirect  $redirect
     * @return void
     */
    public function __construct(Redirect $redirect)
    {
        $this->redirect = $redirect;
    }
}
