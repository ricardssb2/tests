<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TicketUpdateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($ticket, $table)
    {
        $this->ticket = $ticket;
        $this->table = $table;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
                    ->subject('Your ticket '.$this->ticket->title.' has been updated')
                    ->greeting('Hi,')
                    ->line('Your ticket '.$this->ticket->title.':')
                    ->action('View full ticket', route(optional($notifiable)->id ? 'admin.tickets.show' : 'tickets.show', $this->ticket->id))
                    ->line('Thank you')
                    ->line(config('app.name') . ' Team')
                    ->salutation(' ');
    }
}
