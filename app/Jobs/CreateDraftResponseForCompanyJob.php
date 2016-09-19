<?php

namespace App\Jobs;

use App\Company;
use App\Demand\Demand;
use App\Services\DemandService;
use App\Services\ResponseService;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateDraftResponseForCompanyJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var Company
     */
    private $company;

    /**
     * @var ResponseService
     */
    private $responseService;

    /**
     * @var DemandService
     */
    private $demandService;

    /**
     * Create a new job instance.
     *
     * @param Company $company
     */
    public function __construct(Company $company)
    {
        $this->responseService = new ResponseService();
        $this->demandService = new DemandService();
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $this->demandService->findAvailableResponseDemands($this->company)
            ->each(function (Demand $demand) {
                $this->responseService->addItem($this->company->id, $demand->id);
            });
    }
}
