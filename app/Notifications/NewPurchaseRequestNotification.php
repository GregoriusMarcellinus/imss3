<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class NewPurchaseRequestNotification extends Notification
{
    use Queueable;

    protected $purchaseRequest;

    public function __construct($purchaseRequest)
    {
        $this->purchaseRequest = $purchaseRequest;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'purchase_request_id' => $this->purchaseRequest->id,
            'message' => 'A new purchase request has been created.'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'purchase_request_id' => $this->purchaseRequest->id,
            'message' => 'A new purchase request has been created.'
        ]);
    }
}
