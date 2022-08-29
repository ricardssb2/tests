<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class UserNewTicketNotification extends Notification
{
    use Queueable;

    public function __construct($data)
    {
        $this->data = $data;
        $this->ticket = $data['ticket'];
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return $this->getMessage();
    }

    public function getMessage()
    {
        return (new MailMessage)
            ->subject($this->data['action'])
            ->greeting('Dear,'.$this->ticket->author_name)
            ->line($this->data['action'])
            ->line("These are the elements you gave us : ") 
            ->line("Ticket name: ".$this->ticket->title)
            ->line("Brief description: ".Str::limit($this->ticket->content, 200))
            ->line("You can view your ticket by clicking here : ") 
            ->action('View full ticket', route('admin.tickets.show', $this->ticket->id))
            ->line('Thank you for your confidence')
            ->line(config('app.name') . ' Team')
            ->salutation(' ');
    }
}
