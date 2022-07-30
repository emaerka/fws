<?php

namespace App\Notifications\Project;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Arr;

class ChangedNotification extends Notification
{
    use Queueable;

    private $project, $changes;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Project $project, Array $changes)
    {
        $this->project = $project;
        $this->changes = $changes;
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
        $message =  (new MailMessage)
                    ->line('The following project has changed')
                    ->line($this->project->name)
                    ->line('The following datas have been changed:');


        foreach($this->changes as $key => $value)
        {
            $message = $message->line($key . ' : ' . $value);
        }

        return $message;
                   
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
