<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Demand\Response;
class ResponsesTest extends TestCase
{
    use DatabaseMigrations;


    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->setAuthToken();
    }

    public function testUpdateAuth()
    {
        $this->patch('/api/responses/1')
            ->assertStatus(401);
    }

    public function testUpdate()
    {
        //createDemand
        $this->createBeforeDemand();
        $demand = $this->createDemandWithItems(1);

        //createResponse
        $response = $this->createResponseWithItems(0, [
            'company_id' => $this->company->id,
            'status' => \App\Type\ResponseStatus::CANCEL,
            'demand_id' => $demand->id
        ]);

        $data = [
            'delivery_type' => 'sfsdfsd',
            'status' => \App\Type\ResponseStatus::ARCHIVED,
            'responseItems' => [
                [
                    'demand_item_id' => 1,
                    'price' => 23
                ], [
                    'demand_item_id' => 1,
                    'price' => 23
                ]
            ]
        ];

        $r = $this->patch(sprintf('/api/responses/%s?token=%s', $response->id, $this->token), $data);
            $r->assertStatus(202);

        $responses = Response::all();
        $this->assertCount(1, $responses);

        $response = $responses[0];
        $this->assertEquals(\App\Type\ResponseStatus::ARCHIVED, $response->status);
        $this->assertEquals($this->company->id, $response->company_id);
        $this->assertCount(2, $response->responseItems);
    }



    public function testUpdateChange()
    {
        //createDemand
        $this->createBeforeDemand();
        $demand = $this->createDemandWithItems(1);

        //createResponse
        $response = $this->createResponseWithItems(2, [
            'company_id' => $this->company->id,
            'status' => \App\Type\ResponseStatus::CANCEL,
            'demand_id' => $demand->id
        ]);

        $data = [
            'delivery_type' => 'sfsdfsd',
            'status' => \App\Type\ResponseStatus::ARCHIVED,
            'responseItems' => [
                [
                    'demand_item_id' => 1,
                    'price' => 23
                ]
            ]
        ];

        $r = $this->patch(sprintf('/api/responses/%s?token=%s', $response->id, $this->token), $data);
        $r->assertStatus(202);

        $responses = Response::all();
        $this->assertCount(1, $responses);

        $response = $responses[0];
        $this->assertEquals(\App\Type\ResponseStatus::ARCHIVED, $response->status);
        $this->assertEquals($this->company->id, $response->company_id);
        $this->assertCount(1, $response->responseItems);
    }

    public function testUpdateNotForeign()
    {
        //createDemand
        $this->createBeforeDemand();
        $demand = $this->createDemandWithItems(1);

        //createResponse
        $company = factory(\App\Company::class)->create();
        $response = $this->createResponseWithItems(1, [
            'company_id' => $company->id,
            'demand_id' => $demand->id
        ]);

        $data = [
            'delivery_type' => 'sfsdfsd',
            'responseItems' => [
                [
                    'demand_item_id' => 1,
                    'price' => 23
                ], [
                    'demand_item_id' => 1,
                    'price' => 23
                ]
            ]
        ];

        $r = $this->patch(sprintf('/api/responses/%s?token=%s', $response->id, $this->token), $data);
        $r->assertStatus(403);
    }


    public function testUpdateReadedDesc()
    {
        //createDemand
        $this->createBeforeDemand();
        $demand = $this->createDemandWithItems(1);

        //createResponse
        $response = $this->createResponseWithItems(0, [
            'company_id' => $this->company->id,
            'status' => \App\Type\ResponseStatus::DRAFT,
            'demand_id' => $demand->id
        ]);

        $data = [
            'readed' => \Carbon\Carbon::create()->toDateTimeString(),
            'desc' => 'sfsdfsd'
        ];

        $r = $this->patch(sprintf('/api/responses/%s?token=%s', $response->id, $this->token), $data);
        $r->assertStatus(202);

        $response = Response::find($response->id);
        $this->assertNotEmpty($response->readed_time);
        $this->assertEquals($data['desc'], $response->desc);
    }



}
