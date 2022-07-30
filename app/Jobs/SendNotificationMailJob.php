<?php

namespace App\Jobs;

use App\Models\ContactPerson;
use App\Models\Project;
use App\Notifications\Project\ChangedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotificationMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $contactPerson, $project, $changes;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ContactPerson $contactPerson, Project $project, Array $changes)
    {
        $this->contactPerson = $contactPerson;
        $this->project = $project;
        $this->changes = $changes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->contactPerson->notify(new ChangedNotification($this->project, $this->changes));
    }
}
