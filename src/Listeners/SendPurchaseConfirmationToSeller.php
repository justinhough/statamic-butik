<?php

namespace Jonassiewertsen\StatamicButik\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Jonassiewertsen\StatamicButik\Exceptions\OrderConfirmationToSellerNotSent;
use Jonassiewertsen\StatamicButik\Mail\Seller\OrderConfirmation;

class SendPurchaseConfirmationToSeller implements ShouldQueue
{
    use SerializesModels;

    public function handle($event)
    {
        try {
            Mail::to(config('butik.order-confirmations'))
                ->queue(new OrderConfirmation($event->transaction));
        } catch(\Exception $e) {
            throw new OrderConfirmationToSellerNotSent();
        }
    }
}