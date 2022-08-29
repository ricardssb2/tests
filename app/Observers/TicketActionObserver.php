<?php

namespace App\Observers;

use App\Notifications\DataChangeEmailNotification;
use App\Notifications\UserNewTicketNotification;
use App\Notifications\AssignedTicketNotification;
use App\Ticket;
use Illuminate\Support\Facades\Notification;

class TicketActionObserver
{
    public function created(Ticket $model)
    {
        $data  = ['action' => 'New ticket has been created !', 'model_name' => 'Ticket', 'ticket' => $model];
        $dateforuser = ['action' => 'Your ticket has been created !', 'model_name' => 'Ticket', 'ticket' => $model];
        $users = \App\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        // $currentuser = user with same email as the ticket author
        $currentuser = \App\User::where('email', $model->author_email)->first();
        Notification::send($users, new DataChangeEmailNotification($data));
        Notification::send($currentuser, new UserNewTicketNotification($dateforuser));
    }

    public function updated(Ticket $model)
    {
        if($model->isDirty('assigned_to_user_id'))
        {
            $user = $model->assigned_to_user;
            if($user)
            {
                Notification::send($user, new AssignedTicketNotification($model));
            }
        }
    }
}
