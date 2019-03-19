<?php

namespace App\Notifications;

use App\Data\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\NexmoMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class InvoiceDue extends Notification
{
    use Queueable;

    private $user;
    private $invoiceNO;
    private $dueDate;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $invoiceNo, $dueDate)
    {
        $this->invoiceNO = $invoiceNo;
        $this->user = $user;
        $this->dueDate = $dueDate;
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
            'event' => 'INVOICE_DUE',
            "id" => $this->user->id,
            "name" => $this->user->name,
            "due_date" => $this->dueDate,
            "invoice_no" => $this->invoiceNO
        ];
    }

    public function toNexmo($notifiable)
    {
        return ( new NexmoMessage() )
            ->content('invoice # ' . $this->invoiceNO . ' is due on ' . $this->dueDate .' Please pay before due date.')
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
            ->line('Your Invoice# ' . $this->invoiceNO . ' is due on ' . $this->dueDate . '. Kindly pay before the due date.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [];
    }
}
