<?php

namespace App\Listeners;

use App\Events\InvoicePaymentEvent;
use App\Notifications\InvoicePaymentReceived;
use Illuminate\Support\Facades\Notification;

class InvoicePaymentListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param InvoicePaymentEvent $event
     * @return void
     */
    public function handle(InvoicePaymentEvent $event)
    {
        $admins = $event->notifyUser;
        $invoice = $event->invoice;

        if($invoice &&  in_array($invoice->status, ['paid', 'partial'])){
            Notification::send($admins, new InvoicePaymentReceived($invoice));
        }
    }

}
