<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.10.16
 * Time: 0:54
 */

namespace App\Bindings;

use App\Demand\Demand;
use App\Events\Demand\ArchiveDemandEvent;
use App\Listeners\Demand\ArchiveDemandListener;
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
        \Event::listen(ArchiveDemandEvent::class, ArchiveDemandListener::class);

    }

}