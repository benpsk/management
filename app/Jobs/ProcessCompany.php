<?php

namespace App\Jobs;

use App\Events\CompanyCreated;
use App\Models\Company\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCompany implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Company $company)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger('Company created JOB');
        foreach (range(1, 5) as $item) {
            logger($item);
            sleep(1);
        }
        echo "hELLO";
        event(new CompanyCreated($this->company));
        logger('Company created JOB Done');
    }
}
