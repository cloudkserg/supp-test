<?php

namespace App\Jobs;

use App\Company;
use App\Demand\Demand;
use App\Jobs\Job;
use App\Services\CompanyService;
use App\Services\ResponseService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDraftResponseForDemandJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Demand
     */
    private $demand;

    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * Create a new job instance.
     *
     * @param Demand $demand
     */
    public function __construct(Demand $demand)
    {
        $this->responseService = new ResponseService();
        $this->companyService = new CompanyService();
        $this->demand = $demand;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->companyService->findAvailableResponseCompanies($this->demand)
            ->each(function (Company $company) {
                $response = $this->responseService->addItem($company->id, $this->demand->id);
            });
    }
}
