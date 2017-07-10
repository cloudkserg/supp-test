<?php
namespace App\Providers;




use App\Bindings\DemandBinding;
use App\Bindings\DemandItemBinding;
use App\Bindings\InvoiceBinding;
use App\Bindings\ResponseBinding;
use App\Bindings\ResponseItemBinding;
use App\Overwrite\Fractal\ArraySerializer;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //add json api
        $this->app['Dingo\Api\Transformer\Factory']->setAdapter(function ($app) {
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer());
            return new Fractal($fractal, 'include', ',', false);
        });


        (new ResponseBinding())->generateEventBindings();
        (new ResponseItemBinding())->generateEventBindings();
        (new InvoiceBinding())->generateEventBindings();
        (new DemandBinding())->generateEventBindings();
        (new DemandItemBinding())->generateEventBindings();


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
        //
    }
}
