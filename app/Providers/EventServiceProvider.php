<?php

namespace App\Providers;


use App\Bindings\DemandBinding;
use App\Bindings\DemandItemBinding;
use App\Bindings\InvoiceBinding;
use App\Bindings\ResponseBinding;
use App\Bindings\ResponseItemBinding;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\RegisterUserEvent;
use App\Listeners\Mail\User\RegisterUserListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        RegisterUserEvent::class => [
            RegisterUserListener::class
        ],

    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        (new DemandBinding())->generateListenerBindings();
        (new DemandItemBinding())->generateListenerBindings();
        (new InvoiceBinding())->generateListenerBindings();
        (new ResponseBinding())->generateListenerBindings();
        (new ResponseItemBinding())->generateListenerBindings();
        parent::boot();

        //
    }
}
