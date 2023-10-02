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
        logger('Company created');
        foreach (range(1, 10) as $item) {
            logger($item);
            sleep(1);
        }
        echo "hELLO";
        logger('Company created');
        logger($event->company->name);
    }
}
