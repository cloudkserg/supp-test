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
use App\Events\Demand\CreateDemandEvent;
use App\Events\Demand\DeleteDemandEvent;
use App\Listeners\Mail\Demand\CreateDemandListener;
use App\Listeners\Mail\Demand\DeleteDemandListener;
use App\Listeners\Mail\Demand\CancelDemandListener;
use App\Services\DemandService;

class DemandBinding implements BindingInterface
{
    public function generateEventBindings()
    {
        // TODO: Implement generateEventBindings() method.
    }


    public function generateListenerBindings()
    {
        \Event::listen(CreateDemandEvent::class, CreateDemandListener::class);
        \Event::listen(CancelDemandEvent::class, CancelDemandListener::class);
        \Event::listen(CancelDemandEvent::class, \App\Listeners\Response\CancelDemandListener::class);
        \Event::listen(DeleteDemandEvent::class, DeleteDemandListener::class);

    }

}