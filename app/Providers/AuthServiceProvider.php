<?php

namespace App\Providers;

use App\Demand\Demand;
use App\Demand\DemandItem;
use App\Demand\Invoice;
use App\Demand\Response;
use App\Demand\ResponseItem;
use App\Policies\DemandPolicy;
use App\Policies\DemandItemPolicy;
use App\Policies\ResponsePolicy;
use App\Policies\ResponseItemPolicy;
use App\Policies\InvoicePolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Demand::class => DemandPolicy::class,
        DemandItem::class => DemandItemPolicy::class,
        Response::class => ResponsePolicy::class,
        ResponseItem::class => ResponseItemPolicy::class,
        Invoice::class => InvoicePolicy::class
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //
    }
}
