<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Demand\Demand;
class DemandsIndexTest extends TestCase
{
    use DatabaseMigrations;



    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->setAuthToken();
        $this->createThreeActiveOneArchivedOneAnotherActive();
    }



    public function testIndexAuth()
    {
        $this->get('/api/demands')
            ->assertStatus(401);
    }

    private function getJsonStructure()
    {
        return ['*' => [
                'id',
                'title',
                'status',
                'desc',
                'created',
                'address',
                'delivery_date',
                'company' => [
                    'id',
                    'title'
                ],
                'demandItems' => [
                    '*' => [
                        'id',
                        'status',
                        'quantityTitle',
                        'count',
                        'title',
                    ]
                ]
            ]
        ];
    }

    private function createThreeActiveOneArchivedOneAnotherActive()
    {
        //create my own active demands
        $this->createBeforeDemand();
        $this->createDemandWithItems(1, [
            'status' => \App\Type\DemandStatus::ACTIVE,
            'company_id' => $this->company->id
        ]);
        $this->createDemandWithItems(1, [
            'status' => \App\Type\DemandStatus::ACTIVE,
            'company_id' => $this->company->id
        ]);
        $this->createDemandWithItems(2, [
            'status' => \App\Type\DemandStatus::ACTIVE,
            'company_id' => $this->company->id
        ]);

        $this->createDemandWithItems(1, [
            'status' => \App\Type\DemandStatus::ARCHIVED,
            'company_id' => $this->company->id
        ]);
        $company = factory(\App\Company::class)->create();
        $this->createDemandWithItems(1, [
            'status' => \App\Type\DemandStatus::ACTIVE,
            'company_id' => $company->id
        ]);
    }

    public function testIndexActive()
    {
        //active
        $data = http_build_query([
            'status' => \App\Type\DemandStatus::ACTIVE,
            'token' => $this->token
        ]);
        $r = $this->get('/api/demands?' . $data);
        $r->assertStatus(200);
        $data = $r->json();

        $this->assertCount(3, $data);
        $this->assertCount(2, $data[0]['demandItems']);
        $this->assertCount(1, $data[2]['demandItems']);
        $r
            ->assertJsonStructure($this->getJsonStructure());
    }


    public function testIndexArchived()
    {

        //archive
        $data = http_build_query([
            'status' => \App\Type\DemandStatus::ARCHIVED,
            'token' => $this->token
        ]);
        $r = $this->get('/api/demands?' . $data);
        $r->assertStatus(200);
        $data = $r->json();

        $this->assertCount(1, $data);
        $r
            ->assertJsonStructure($this->getJsonStructure());
    }

    public function testIndexSomeStatuses()
    {
        //with some status
        $data = http_build_query([
            'token' => $this->token,
            'status' => array(\App\Type\DemandStatus::ACTIVE, \App\Type\DemandStatus::ARCHIVED)
        ]);
        $r = $this->get('/api/demands?' . $data);
        $r->assertStatus(200);
        $data = $r->json();

        $this->assertCount(4, $data);
        $r
            ->assertJsonStructure($this->getJsonStructure());
    }

    public function testIndexWithoutStatus()
    {

        //without status
        $data = http_build_query([
            'token' => $this->token
        ]);
        $r = $this->get('/api/demands?' . $data);
        $r->assertStatus(200);
        $data = $r->json();
        $this->assertCount(4, $data);
        $r
            ->assertJsonStructure($this->getJsonStructure());
    }

    private function createResponseWithOneItem(Demand $demand)
    {
        $response = $this->createResponseWithItems(1, [
            'demand_id' => $demand->id,
            'status' => \App\Type\ResponseStatus::ACTIVE
        ]);
        $response->responseItems[0]->demand_item_id = $demand->demandItems[0]->id;
        return $response;
    }

    private function createResponseWithTwoItems(Demand $demand)
    {
        $response = $this->createResponseWithItems(2, [
            'demand_id' => $demand->id,
            'status' => \App\Type\ResponseStatus::ACTIVE
        ]);
        $response->responseItems[0]->demand_item_id = $demand->demandItems[0]->id;
        $response->responseItems[1]->demand_item_id = $demand->demandItems[1]->id;
        return $response;
    }



    public function testIndexWithInvoice()
    {
        $demand = Demand::whereStatus(\App\Type\DemandStatus::ARCHIVED)->first();
        $demand->demandItems()->save(factory(\App\Demand\DemandItem::class)->make());

        $response = $this->createResponseWithOneItem($demand);
        $invoice = factory(\App\Demand\Invoice::class)->create([
            'response_id' => $response->id,
        ]);
        $response->responseItems[0]->invoice_id = $invoice->id;
        $response->responseItems[0]->save();

        $data = http_build_query([
            'token' => $this->token,
            'status' => \App\Type\DemandStatus::ARCHIVED
        ]);
        $r = $this->get('/api/demands?' . $data);
        $r->assertStatus(200);
            $r->assertJsonStructure($this->getInvoiceJsonStructure());

        $data = $r->json();
        $jsonDemand = $data[0];
        $jsonResponse = $jsonDemand['responses'][0];

        //has invoices
        $this->assertCount(1, $jsonResponse['invoices']);

        //responseItem link to invoice_id
        $this->assertEquals($invoice->id, $jsonResponse['responseItems'][0]['invoice_id']);
    }

    public function testIndexWithResponse()
    {
        $demand = Demand::whereStatus(\App\Type\DemandStatus::ARCHIVED)->first();
        $demand->demandItems()->save(factory(\App\Demand\DemandItem::class)->make());

        $this->createResponseWithOneItem($demand);
        $this->createResponseWithTwoItems($demand);

        $data = http_build_query([
            'token' => $this->token,
            'status' => \App\Type\DemandStatus::ARCHIVED
        ]);
        $r = $this->get('/api/demands?' . $data);
        $r->assertStatus(200);
        $r->assertJsonStructure($this->getResponseJsonStructure());

        $data = $r->json();

        //same demand
        $jsonDemand = $data[0];

        //demand with items
        $this->assertCount(2, $jsonDemand['demandItems']);
        //demand with two responses
        $this->assertCount(2, $jsonDemand['responses']);

        //response with one and two response items
        $responses = $jsonDemand['responses'];
        $this->assertCount(1, $responses[0]['responseItems']);
        $this->assertCount(2, $responses[1]['responseItems']);
    }

    private function getResponseJsonStructure()
    {
        $struct = $this->getJsonStructure();
        $struct['*']['responses'] = [
            '*' => [
                'id',
                'status',
                'delivery_type',
                'company' => [
                    'id',
                    'title'
                ],
                'responseItems' => [
                    '*' => [
                        'id',
                        'status',
                        'price',
                        'demand_item_id'
                    ]
                ]
            ]
        ];
        return $struct;
    }


    private function getInvoiceJsonStructure()
    {
        $struct = $this->getResponseJsonStructure();
        $struct['*']['responses']['*']['invoices'] = [
            '*' => [
                'id',
                'status'
            ]
        ];
        return $struct;
    }




}
