<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 18.09.16
 * Time: 20:07
 */

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Demand\Response;

class CreateDraftResponsesForDemandJobTest extends TestCase
{
    use DatabaseMigrations;

    private $spheres;

    private $regions;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        //company
        $this->spheres = factory(\App\Type\Sphere::class, 2)->create();
        $this->regions = factory(\App\Type\Region::class, 2)->create();

        $this->createBeforeCompany();
        $this->company = factory(\App\Company::class)->create();
        $this->attachCompanyToSphereAndRegion(
            $this->company,
            [$this->spheres[0]->id],
            [$this->regions[0]->id]
        );
    }

    private function createDemand()
    {
        $companyDemand = factory(\App\Company::class)->create();
        $this->attachCompanyToSphereAndRegion(
            $companyDemand,
            [$this->spheres[0]->id],
            [$this->regions[0]->id]
        );
        $this->createBeforeDemand();
        return $this->createDemandWithItems(1, [
            'company_id' => $companyDemand->id,
            'spheres' => [$this->spheres[0]->id],
            'regions' => [$this->regions[0]->id]
        ]);
    }


    public function testHandleCreate()
    {
        $company = factory(\App\Company::class)->create();
        $this->attachCompanyToSphereAndRegion(
            $company,
            [$this->spheres[0]->id],
            [$this->regions[0]->id]
        );

        $demand = $this->createDemand();

        $job = new \App\Jobs\CreateDraftResponseForDemandJob($demand);
        $job->handle();

        $responses = Response::query()->get();
        $this->assertCount(2, $responses);

        $response = $responses[0];
        $this->assertEquals($this->company->id, $response->company_id);
        $this->assertEquals($demand->id, $response->demand_id);
        $this->assertEquals(\App\Type\ResponseStatus::DRAFT, $response->status);

        $response = $responses[1];
        $this->assertEquals($company->id, $response->company_id);
        $this->assertEquals($demand->id, $response->demand_id);
        $this->assertEquals(\App\Type\ResponseStatus::DRAFT, $response->status);

    }

    public function testHandleCreateWhenForeignResponse()
    {
        $demand = $this->createDemand();

        $company = factory(\App\Company::class)->create();
        $this->createResponseWithItems(1, [
            'demand_id' => $demand->id,
            'company_id' => $company->id
        ]);

        $job = new \App\Jobs\CreateDraftResponseForDemandJob($demand);
        $job->handle();

        $responses = Response::query()->get();
        $this->assertCount(2, $responses);

    }



    public function testHandleNotCreateWhenResponse()
    {
        $demand = $this->createDemand();

        $this->createResponseWithItems(1, [
            'demand_id' => $demand->id,
            'company_id' => $this->company->id
        ]);

        $job = new \App\Jobs\CreateDraftResponseForDemandJob($demand);
        $job->handle();

        $responses = Response::query()->get();
        $this->assertCount(1, $responses);

    }

}