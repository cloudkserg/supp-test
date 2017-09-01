<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class MessagesTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->createBeforeDemand();
        $this->setAuthToken();
    }


    public function testIndexNotAuth()
    {
        $r = $this->get('/api/messages')
            ->assertStatus(401);
    }



    public function testIndexEmpty()
    {
        $this->createBeforeDemand();
        $demand = $this->createDemandWithItems(1);

        $r = $this->get('/api/messages?demandId=' . $demand->id . '&token=' . $this->token);
        $r->assertStatus(200);

        $messages = $r->json();
        $this->assertEmpty($messages);
    }

    public function testIndexDemandAndStatus()
    {
        $this->createBeforeDemand();

        $demand1 = $this->createDemandWithItems(1);
        $demand2 = $this->createDemandWithItems(1);

        $foreignCompany = factory(\App\Company::class)->create();
        $originMessages = [];
        $originMessages[] = factory(\App\Message::class)->create([
            'demand_id' => $demand1->id,
            'from_company_id' => $this->company->id,
            'to_company_id' => $foreignCompany->id,
            'text' => 'bla1'
        ]);
        $originMessages[] = factory(\App\Message::class)->create([
            'demand_id' => $demand1->id,
            'from_company_id' => $foreignCompany->id,
            'to_company_id' => $this->company->id,
            'text' => 'bla2'
        ]);
        factory(\App\Message::class)->create([
            'demand_id' => $demand2->id,
            'from_company_id' => $foreignCompany->id,
            'to_company_id' => $this->company->id,
            'text' => 'bla3'
        ]);

        $r = $this->get('/api/messages?demandId=' . $demand1->id . '&token=' . $this->token);
        $r->assertStatus(200)
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'demandId',
                    'fromCompanyId',
                    'toCompanyId',
                    'text',
                    'readed',
                    'status',
                    'created'
                ]
            ]);

        $messages = $r->json();
        $this->assertCount(2, $messages);

        $this->assertEquals($originMessages[0]->text, $messages[0]['text']);
    }

    public function testIndexOnlyThisDemandAndOrder()
    {
        $this->createBeforeDemand();

        $demand1 = $this->createDemandWithItems(1);
        $demand2 = $this->createDemandWithItems(1);

        $foreignCompany = factory(\App\Company::class)->create();
        $originMessages = [];
        $originMessages[] = factory(\App\Message::class)->create([
            'demand_id' => $demand1->id,
            'from_company_id' => $this->company->id,
            'to_company_id' => $foreignCompany->id,
            'text' => 'bla1'
        ]);
        $originMessages[] = factory(\App\Message::class)->create([
            'demand_id' => $demand1->id,
            'from_company_id' => $foreignCompany->id,
            'to_company_id' => $this->company->id,
            'text' => 'bla2'
        ]);
        factory(\App\Message::class)->create([
            'demand_id' => $demand2->id,
            'from_company_id' => $foreignCompany->id,
            'to_company_id' => $this->company->id,
            'text' => 'bla3'
        ]);

        $r = $this->get('/api/messages?demandId=' . $demand1->id . '&token=' . $this->token);
        $r->assertStatus(200);

        $messages = $r->json();
        $this->assertCount(2, $messages);

        $this->assertEquals($originMessages[0]->text, $messages[0]['text']);
        $this->assertEquals($originMessages[1]->text, $messages[1]['text']);
    }


    public function testIndexWhereInFromCompanyId()
    {
        $foreignCompany = factory(\App\Company::class)->create();
        $foreignCompany2 = factory(\App\Company::class)->create();
        $demand = $this->createDemandWithItems(1, [
            'company_id' => $this->company->id
        ]);

        factory(\App\Message::class)->create([
            'demand_id' => $demand->id,
            'from_company_id' => $foreignCompany->id,
            'to_company_id' => $foreignCompany2->id,
            'text' => 'blaanother'
        ]);
        $message = factory(\App\Message::class)->create([
            'demand_id' => $demand->id,
            'from_company_id' => $this->company->id,
            'to_company_id' => $foreignCompany->id,
            'text' => 'bla1'
        ]);

        $r = $this->get('/api/messages?demandId=' . $demand->id . '&token=' . $this->token);
        $messages = $r->json();
        $this->assertCount(1, $messages);

        $this->assertEquals($message->text, $messages[0]['text']);
    }


    public function testIndexWhereInToCompanyId()
    {
        $foreignCompany = factory(\App\Company::class)->create();
        $foreignCompany2 = factory(\App\Company::class)->create();
        $demand = $this->createDemandWithItems(1, [
            'company_id' => $this->company->id
        ]);

        factory(\App\Message::class)->create([
            'demand_id' => $demand->id,
            'from_company_id' => $foreignCompany->id,
            'to_company_id' => $foreignCompany2->id,
            'text' => 'blaanother'
        ]);
        $message = factory(\App\Message::class)->create([
            'demand_id' => $demand->id,
            'from_company_id' => $foreignCompany->id,
            'to_company_id' => $this->company->id,
            'text' => 'bla1'
        ]);

        $r = $this->get('/api/messages?demandId=' . $demand->id . '&token=' . $this->token);
        $messages = $r->json();
        $this->assertCount(1, $messages);

        $this->assertEquals($message->text, $messages[0]['text']);
    }

    public function testIndexArchived()
    {
        $foreignCompany = factory(\App\Company::class)->create();
        $demand = $this->createDemandWithItems(1, [
            'company_id' => $this->company->id
        ]);

        factory(\App\Message::class)->create([
            'demand_id' => $demand->id,
            'from_company_id' => $this->company->id,
            'to_company_id' => $foreignCompany->id,
            'text' => 'blaanother'
        ]);
        $message = factory(\App\Message::class)->create([
            'demand_id' => $demand->id,
            'status' => \App\Type\MessageStatus::ARCHIVED,
            'from_company_id' => $foreignCompany->id,
            'to_company_id' => $this->company->id,
            'text' => 'bla1'
        ]);

        $r = $this->get('/api/messages?demandId=' . $demand->id . '&token=' . $this->token . '&status=' . \App\Type\MessageStatus::ARCHIVED);
        $messages = $r->json();
        $this->assertCount(1, $messages);

        $this->assertEquals($message->text, $message['text']);
    }



    public function testIndexActive()
    {
        $foreignCompany = factory(\App\Company::class)->create();
        $demand = $this->createDemandWithItems(1, [
            'company_id' => $this->company->id
        ]);

        $message = factory(\App\Message::class)->create([
            'demand_id' => $demand->id,
            'from_company_id' => $this->company->id,
            'to_company_id' => $foreignCompany->id,
            'text' => 'blaanother'
        ]);
        factory(\App\Message::class)->create([
            'demand_id' => $demand->id,
            'status' => \App\Type\MessageStatus::ARCHIVED,
            'from_company_id' => $foreignCompany->id,
            'to_company_id' => $this->company->id,
            'text' => 'bla1'
        ]);

        $r = $this->get('/api/messages?demandId=' . $demand->id . '&token=' . $this->token);
        $messages = $r->json();
        $this->assertCount(1, $messages);

        $this->assertEquals($message->text, $message['text']);
    }


    public function testStoreNotAuth()
    {
        $r = $this->post('/api/messages', [
            'text' => 'bla1'
        ])
            ->assertStatus(401);
    }


    public function testStoreRight()
    {
        $foreignCompany = factory(\App\Company::class)->create();
        $demand = factory(\App\Demand\Demand::class)->create([
            'company_id' => $this->company->id
        ]);

        $this->createResponseWithItems(0, [
            'demand_id' => $demand->id,
            'company_id' => $foreignCompany->id
        ]);

        $r = $this->post('/api/messages?token=' . $this->token, [
            'demandId' => $demand->id,
            'toCompanyId' => $foreignCompany->id,
            'text' => 'bla1'
        ]);
        $r->assertStatus(201)
            ->assertHeader('location', '/messages/1');

        $message = \App\Message::first();
        $this->assertEquals('bla1', $message->text);
        $this->assertEquals(\App\Type\MessageStatus::ACTIVE, $message->status);
        $this->assertEquals($this->company->id, $message->from_company_id);
        $this->assertEquals($foreignCompany->id, $message->to_company_id);
        $this->assertNotEmpty($message->created_at);
        $this->assertEquals($demand->id, $message->demand_id);
    }


    public function testStoreNotDemandError()
    {
        $foreignCompany = factory(\App\Company::class)->create();


        $r = $this->post('/api/messages?token=' . $this->token, [
            'toCompanyId' => $foreignCompany->id,
            'text' => 'bla1'
        ]);
        $r->assertStatus(404);
    }

    public function testStoreNotCompanyError()
    {
        $demand = factory(\App\Demand\Demand::class)->create([
            'company_id' => $this->company->id
        ]);

        $r = $this->post('/api/messages?token=' . $this->token, [
            'demandId' => $demand->id,
            'text' => 'bla1'
        ]);
        $r->assertStatus(422);
    }

    public function testStoreNotText()
    {
        $foreignCompany = factory(\App\Company::class)->create();
        $demand = factory(\App\Demand\Demand::class)->create([
            'company_id' => $this->company->id
        ]);

        $r = $this->post('/api/messages?token=' . $this->token, [
            'demandId' => $demand->id,
            'toCompanyId' => $foreignCompany->id
        ]);
        $r->assertStatus(422);
    }

    public function testStoreMyAnotherDemand()
    {
        $foreignCompany = factory(\App\Company::class)->create();
        $demand = factory(\App\Demand\Demand::class)->create([
            'company_id' => $foreignCompany->id
        ]);
        $this->createResponseWithItems(0, [
            'demand_id' => $demand->id,
            'company_id' => $this->company->id
        ]);

        $r = $this->post('/api/messages?token=' . $this->token, [
            'demandId' => $demand->id,
            'text' => 'bla1',
            'toCompanyId' => $foreignCompany->id
        ]);
        $r->assertStatus(201);
    }

    public function testStoreNotForeignDemand()
    {
        $foreignCompany = factory(\App\Company::class)->create();
        $foreignCompany2 = factory(\App\Company::class)->create();
        $demand = factory(\App\Demand\Demand::class)->create([
            'company_id' => $foreignCompany->id
        ]);

        $r = $this->post('/api/messages?token=' . $this->token, [
            'demandId' => $demand->id,
            'text' => 'bla1',
            'toCompanyId' => $foreignCompany2->id
        ]);
        $r->assertStatus(403);
    }

    public function testStoreNotMyDemand()
    {
        $foreignCompany = factory(\App\Company::class)->create();
        $demand = factory(\App\Demand\Demand::class)->create([
            'company_id' => $foreignCompany->id
        ]);

        $r = $this->post('/api/messages?token=' . $this->token, [
            'demandId' => $demand->id,
            'text' => 'bla1',
            'toCompanyId' => $foreignCompany->id
        ]);
        $r->assertStatus(403);
    }

    public function testStoreNotActiveDemand()
    {
        $foreignCompany = factory(\App\Company::class)->create();
        $demand = factory(\App\Demand\Demand::class)->create([
            'status' => \App\Type\DemandStatus::ARCHIVED,
            'company_id' => $foreignCompany->id
        ]);
        $this->createResponseWithItems(0, [
            'demand_id' => $demand->id,
            'company_id' => $this->company->id
        ]);

        $r = $this->post('/api/messages?token=' . $this->token, [
            'demandId' => $demand->id,
            'text' => 'bla1',
            'toCompanyId' => $foreignCompany->id
        ]);

        $r->assertStatus(201);
    }








}
