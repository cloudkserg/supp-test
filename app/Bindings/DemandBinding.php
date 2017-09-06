<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.10.16
 * Time: 0:54
 */

namespace App\Bindings;

use App\Demand\Demand;
use App\Events\Demand\CancelDemandEvent;
use App\Events\Demand\DeleteDemandEvent;
use App\Listeners\Mail\Demand\DeleteDemandListener;
use App\Listeners\Mail\Demand\CancelDemandListener;
use App\Services\DemandService;

class DemandBinding implements BindingInterface
{
    public function generateEventBindings()
    {
        Demand::updated(function (Demand $item) {
            (new DemandService())->onUpdate($item);
        });
    }

    public function generateListenerBindings()
    {
        \Event::listen(CancelDemandEvent::class, CancelDemandListener::class);
        \Event::listen(DeleteDemandEvent::class, DeleteDemandListener::class);

    }

}