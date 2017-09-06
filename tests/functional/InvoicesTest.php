<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Events\Invoice\CreateInvoiceEvent;
use Illuminate\Support\Facades\Event;
use App\Events\Invoice\DeleteInvoiceEvent;
class InvoicesTest extends TestCase
{
    use DatabaseMigrations;

    private $responseModel;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->setAuthToken();
        $this->createBeforeDemand();
        $this->createDemandWithItems(1);
        $this->responseModel = $this->createResponseWithItems(3, [
            'company_id' => $this->company->id
        ]);

    }


    public function testCreateAuth()
    {
        $this->post('/api/invoices')
            ->assertStatus(401);
    }

    public function testCreateRight()
    {
        Event::fake();
        $data = [
            'responseItems' => [
                $this->responseModel->responseItems[0]->id,
                $this->responseModel->responseItems[1]->id
            ]
        ];

        $r = $this->post('/api/invoices?token=' . $this->token, $data);
            $r->assertStatus(201)
            ->assertHeader('location', '/invoices/1');


        //check isset invoice
        $items = $this->responseModel->invoices;
        $this->assertCount(1, $items);

        //check invoice responseItems
        $item = $items[0];
        $this->assertCount(2, $item->responseItems);

        //check invoice event
        Event::assertDispatched(CreateInvoiceEvent::class, function ($e)  {
            return (
                $e->item->exists and
                count($e->item->responseItems) == 2
            );
        });
    }

    public function testNotCreateRights()
    {
        $company = factory(\App\Company::class)->create();
        $response = $this->createResponseWithItems(1, [
            'company_id' => $company->id
        ]);
        $data = [
            'responseItems' => [
                $this->responseModel->responseItems[0]->id,
                $response->responseItems[0]->id
            ]
        ];

        $this->post('/api/invoices?token=' . $this->token, $data)
            ->assertStatus(403);

        $items = $this->responseModel->invoices;
        $this->assertCount(0, $items);
    }

    public function testFileAuth()
    {
        $this->get('/api/invoices/1/files/abba')
            ->assertStatus(401);
    }

    public function testFileForeign()
    {
        //invoice
        $company = factory(\App\Company::class)->create();
        $response = factory(\App\Demand\Response::class)->create([
            'company_id' => $company->id
        ]);
        $item = factory(\App\Demand\Invoice::class)->create([
            'response_id' => $response->id,
        ]);

        $r = $this->get('/api/invoices/' . $item->id . '/files/abba?token=' . $this->token)
            ->assertStatus(403);
    }

    private function createFile($invoiceId)
    {
        $oldmask = umask(0);
        //create file
        $faker = Faker\Factory::create();
        $path = storage_path('app/invoices/' . $invoiceId);
        $filepath = $faker->file('/tmp', $path);
        chmod($filepath, 0777);
        umask($oldmask);

        return $filepath;
    }


    public function testFileRight()
    {
        //invoice
        $item = factory(\App\Demand\Invoice::class)->create([
            'response_id' => $this->responseModel->id
        ]);
        $filepath  = $this->createFile($item->id);
        $filename = File::basename($filepath);
        $item->filename = $filename;
        $item->save();


        $this->get('/api/invoices/' . $item->id . '/files/' . $filename . '?token=' . $this->token)
            ->assertStatus(200);
        \File::delete($filepath);
    }

    public function testUpdateAuth()
    {
        $this->put('/api/invoices/11')
            ->assertStatus(401);
    }

    public function testUpdateRight()
    {
        Event::fake();
        /**
         * Создаем инвойс с файлом
         */
        $item = factory(\App\Demand\Invoice::class)->create([
            'response_id' => $this->responseModel->id
        ]);
        $path = storage_path('app/tests/report.xls');
        $newPath = storage_path('app/report.xls');
        File::copy($path, $newPath);

        //отправляем файл в инвойс
        $file = new \Illuminate\Http\UploadedFile($newPath, 'file', 'application/excel', 446, null, true);
        $data = [
            'file' => $file
        ];
        $r = $this->put('/api/invoices/' . $item->id . '/?token=' . $this->token,
            $data
        );
        $r->assertStatus(202);

        //инвойс создан с этим файлом
        $invoice = \App\Demand\Invoice::first();
        $this->assertEquals('report.xls', $invoice->filename);
        $this->assertTrue(file_exists($invoice->filepath));

        //удаляем инвойс с файлом
        $service = new \App\Services\InvoiceService();
        $service->deleteItem($invoice);


        Event::assertDispatched(\App\Events\Invoice\ResponsedInvoiceEvent::class, function ($e) use ($item) {
            return (
                $e->item->id == $item->id
            );
        });
    }


    public function testDeleteAuth()
    {
        $this->delete('/api/invoices/11')
            ->assertStatus(401);
    }

    public function testDeleteRight()
    {
        Event::fake();
        $item = factory(\App\Demand\Invoice::class)->create([
            'response_id' => $this->responseModel->id
        ]);

        $r = $this->delete('/api/invoices/' . $item->id . '/?token=' . $this->token);
        $r->assertStatus(202);

        $this->assertEquals(0, \App\Demand\Invoice::count());

        Event::assertDispatched(DeleteInvoiceEvent::class, function ($e) use ($item) {

            return (
                $e->item->id == $item->id
            );
        });
    }

    public function testDeleteForeign()
    {
        $company = factory(\App\Company::class)->create();
        $response = $this->createResponseWithItems(1, [
            'company_id' => $company->id
        ]);
        $item = factory(\App\Demand\Invoice::class)->create([
            'response_id' => $response->id
        ]);

        $r = $this->delete('/api/invoices/' . $item->id . '/?token=' . $this->token);
        $r->assertStatus(403);

        $this->assertEquals(1, \App\Demand\Invoice::count());
    }





}
