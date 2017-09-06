<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.10.16
 * Time: 0:54
 */

namespace App\Bindings;

use App\Demand\ResponseItem;
use App\Events\ResponseItem\ChangeResponseItemEvent;
use App\Events\ResponseItem\DeleteResponseItemEvent;
use App\Listeners\Mail\ResponseItem\ChangeResponseItemListener;
use App\Listeners\Mail\ResponseItem\DeleteResponseItemListener;
use App\Services\ResponseItemService;

class ResponseItemBinding implements BindingInterface
{
    public function generateEventBindings()
    {
        $service = new ResponseItemService();
        ResponseItem::updated(function (ResponseItem $item) use ($service) {
            $service->onUpdate($item);
        });

        ResponseItem::deleted(function (ResponseItem $item) use ($service) {
            $service->onDelete($item);
        });
    }

    public function generateListenerBindings()
    {
        \Event::listen(ChangeResponseItemEvent::class, ChangeResponseItemListener::class);
        \Event::listen(DeleteResponseItemEvent::class, DeleteResponseItemListener::class);
    }

}