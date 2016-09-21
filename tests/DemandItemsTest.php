<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
class DemandsItemsTest extends TestCase
{
    use DatabaseMigrations;


    private $demand;

    private $demandItem;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->setAuthToken();
        $this->createBeforeDemand();
    }


    public function testUpdateAuth()
    {
        $demand = $this->createDemandWithItems(1);
        $demandItem = $demand->demandItems[0];

        $this->patch('/api/demandItems/' . $demandItem->id)
            ->seeStatusCode(401);
    }


    public function testUpdateRight()
    {
        $demand = $this->createDemandWithItems(1, [
            'company_id' => $this->company->id
        ]);
        $demandItem = $demand->demandItems[0];
        $response = $this->createResponseWithItems(1);
        $responseItem = $response->responseItems[0];

        $data = [
            'response_item_id' => $responseItem->id
        ];

        $r = $this->patch('/api/demandItems/' . $demandItem->id . '?token=' . $this->token,
            $data);
        $r->seeStatusCode('202');

        $newItem = \App\Demand\DemandItem::find($demandItem->id);
        $this->assertEquals($responseItem->id, $newItem->response_item_id);
    }

    public function testUpdateForeign()
    {
        $company = factory(\App\Company::class)->create();
        $demand = $this->createDemandWithItems(1, [
            'company_id' => $company->id
        ]);
        $demandItem = $demand->demandItems[0];
        $response = $this->createResponseWithItems(1);
        $data = [
            'response_item_id' => $response->responseItems[0]->id
        ];

        $r = $this->patch('/api/demandItems/' . $demandItem->id . '?token=' . $this->token,
            $data);
        $r->seeStatusCode('403');

        $newItem = \App\Demand\DemandItem::find($demandItem->id);
        $this->assertTrue(!isset($newItem->response_item_id));
    }

    public function testUpdateUnselect()
    {
        $demand = $this->createDemandWithItems(1, [
            'company_id' => $this->company->id
        ]);
        $demandItem = $demand->demandItems[0];
        $response = $this->createResponseWithItems(1);
        $responseItem = $response->responseItems[0];
        $demandItem->response_item_id = $responseItem->id;

        $data = [
        ];

        $r = $this->patch('/api/demandItems/' . $demandItem->id . '?token=' . $this->token,
            $data);
        $r->seeStatusCode('202');

        $newItem = \App\Demand\DemandItem::find($demandItem->id);
        $this->assertTrue(!isset($newItem->responseItem));
    }




}
