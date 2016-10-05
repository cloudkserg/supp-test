<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 04.10.16
 * Time: 22:42
 */

use Illuminate\Support\Facades\Event;
use App\Events\ResponseItem\ChangeResponseItemEvent;
use App\Events\ResponseItem\DeleteResponseItemEvent;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class GenerateResponseItemsEventsTest extends \TestCase
{
    use DatabaseMigrations;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->createBeforeCompany();
        factory(\App\Company::class)->create();
        $this->createBeforeDemand();
        $this->createDemandWithItems(1);
    }



    public function testUpdated()
    {
        Event::fake();
        $oldPrice = 22;
        $response = $this->createResponseWithItems(1, [], [
            'price' => $oldPrice
        ]);
        $responseItem = $response->responseItems[0];

        $responseItem->price = 44;
        $responseItem->save();

        Event::assertFired(ChangeResponseItemEvent::class, function ($e) use ($responseItem, $oldPrice) {
            return (
                $e->item->id == $responseItem->id and
                $e->oldPrice == $oldPrice
            );
        });
    }

    public function testDeleted()
    {
        Event::fake();
        $response = $this->createResponseWithItems(1);
        $responseItem = $response->responseItems[0];

        $responseItem->delete();

        Event::assertFired(DeleteResponseItemEvent::class, function ($e) use ($responseItem) {
            return (
                $e->item->id == $responseItem->id
            );
        });
    }

}