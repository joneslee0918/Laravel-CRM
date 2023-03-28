<?php

namespace App\Observers;

use App\ClientPayment;
use App\Invoice;
use App\Notifications\InvoicePaymentReceived;
use App\User;
use Illuminate\Support\Facades\Notification;

class InvoicePaymentReceivedObserver
{

    public function created(ClientPayment $payment)
    {
        try{
            if (!isRunningInConsoleOrSeeding()) {
                $admins = User::frontAllAdmins($payment->company_id);
                $invoice = Invoice::findOrFail($payment->invoice_id);
    
                if($invoice  && in_array($invoice->status, ['paid', 'partial'])){
                    Notification::send($admins, new InvoicePaymentReceived($invoice));
                }
            }
        }catch (\Exception $e){

        }
    }

}
