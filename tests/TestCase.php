<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    const PASSWORD = '123456';

    protected $user;

    protected $token;

    protected $company;


    protected function setAuthToken()
    {
        $this->createBeforeCompany();
        $this->company = $this->createCompany();
        $userService = new \App\Services\UserService();
        $this->user = factory(\App\User::class)->create([
            'password' => $userService->encryptPassword(self::PASSWORD)
        ]);

        $r = $this->post('/api/tokens', [
            'email' => $this->user->email,
            'password' => self::PASSWORD
        ]);
        $this->token = json_decode($r->response->content())->token;

    }

    protected function createCompany()
    {
        $faker = Faker\Factory::create();
        $company = factory(\App\Company::class)->create();
        $company->spheres()->attach($faker->randomElements(
            \App\Type\Sphere::pluck('id')->toArray()
        ));
        $company->regions()->attach($faker->randomElements(
            \App\Type\Region::pluck('id')->toArray()
        ));
        return $company;
    }

    protected function createBeforeCompany()
    {
        factory(\App\Type\Region::class, 2)->create();
        factory(\App\Type\Sphere::class, 2)->create();
    }

    protected function createBeforeDemand()
    {
        factory(\App\Type\Quantity::class, 2)->create();
    }

    protected function createBeforeResponse()
    {
        factory(\App\Type\DeliveryType::class, 2)->create();

    }

    protected function createDemandWithItems($count, $countItems, $data = [], $demandItemData = [])
    {
        for ($i=0; $i<$count; $i++) {
            $demand = factory(\App\Demand\Demand::class)->create($data);
            for($j=0; $j<$countItems;$j++) {
                $demand->demandItems()->save(factory(\App\Demand\DemandItem::class)->make($demandItemData));
            }
        }
    }

}
