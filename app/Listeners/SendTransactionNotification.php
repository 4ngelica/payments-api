<?php

namespace App\Listeners;

use App\Events\TransactionReceived;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Exception;


class SendTransactionNotification
{
    const NOTIFICATION_URL = 'http://o4d9z.mocklab.io/notify';
    /**
    * Handle the event.
    *
    * @param  \App\Events\TransactionReceived  $event
    * @return void
    */
    public function handle(TransactionReceived $event)
    {
        $user = $event->user;
        $response = Http::post(self::NOTIFICATION_URL, $user->toArray());
        $response->throw();

        if ($response['message'] !== 'Success') {
            throw new Exception('The transaction notification cannot be sent.');
        }
    }
}
