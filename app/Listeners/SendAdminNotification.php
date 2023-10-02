<?php

namespace App\Listeners;

use App\Events\CompanyCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAdminNotification implements ShouldQueue
{
    public $afterCommit = true;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CompanyCreated $event): void
    {
        logger('Company created Listener');
        logger($event->company->name);
    }
}
