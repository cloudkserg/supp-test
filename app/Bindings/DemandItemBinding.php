<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.10.16
 * Time: 0:57
 */

namespace App\Bindings;


use App\Demand\DemandItem;
use App\Events\DemandItem\SelectedResponseItemEvent;
use App\Events\DemandItem\UnselectedResponseItemEvent;
use App\Listeners\Mail\DemandItem\SelectedResponseItemListener;
use App\Listeners\Mail\DemandItem\UnselectedResponseItemListener;
use App\Services\DemandItemService;

class DemandItemBinding implements BindingInterface
{
    public function generateEventBindings()
    {
        DemandItem::updated(function (DemandItem $item) {
            (new DemandItemService())->onUpdate($item);
        });
    }

    public function generateListenerBindings()
    {
        \Event::listen(SelectedResponseItemEvent::class, SelectedResponseItemListener::class);
        \Event::listen(UnselectedResponseItemEvent::class, UnselectedResponseItemListener::class);
    }


}