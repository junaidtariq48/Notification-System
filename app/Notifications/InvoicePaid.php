<?php

namespace App\Notifications;

use App\Data\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvoicePaid extends Notification
{
    use Queueable;

    private $user;
    private $invoiceNO;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $invoiceNo)
    {
        $this->invoiceNO = $invoiceNo;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database','nexmo'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'event' => 'INVOICE_PAID',
            "id" => $this->user->id,
            "name" => $this->user->name,
            "invoice_no" => $this->invoiceNO
        ];
    }

    public function toNexmo($notifiable)
    {
        return ( new NexmoMessage )
            ->content($this->user->name . ' invoice has been paid. invoice# ' . $this->invoiceNO)
            ->from('nexmo');
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line($this->user->name . '  Invoice# ' . $this->invoiceNO . ' has been paid.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
