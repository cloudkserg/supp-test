<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.10.16
 * Time: 0:54
 */

namespace App\Bindings;

use App\Demand\Response;
use App\Events\Response\ActiveResponseEvent;
use App\Events\Response\CancelResponseEvent;
use App\Events\Response\ChangeResponseEvent;
use App\Events\Response\CreateResponseEvent;
use App\Listeners\Mail\Response\ActiveResponseListener;
use App\Listeners\Mail\Response\CancelResponseListener;
use App\Listeners\Mail\Response\ChangeResponseListener;
use App\Listeners\Mail\Response\CreateResponseListener;
use App\Services\ResponseService;

class ResponseBinding implements BindingInterface
{
    public function generateEventBindings()
    {
        $service = new ResponseService();
        Response::created(function (Response $item) use($service) {
            $service->onCreate($item);
        });

        Response::updated(function (Response $item) use ($service) {
            $service->onUpdate($item);
        });
    }

    public function generateListenerBindings()
    {
        \Event::listen(ActiveResponseEvent::class, ActiveResponseListener::class);
        \Event::listen(CancelResponseEvent::class, CancelResponseListener::class);
        \Event::listen(ChangeResponseEvent::class, ChangeResponseListener::class);
        \Event::listen(CreateResponseEvent::class, CreateResponseListener::class);


    }

}