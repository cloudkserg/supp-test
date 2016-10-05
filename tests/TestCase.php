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
        $this->company = factory(\App\Company::class)->create();
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

    protected function attachDemandToSphereAndRegion(\App\Demand\Demand $demand, $spheres, $regions)
    {
        $demand->spheres()->attach($spheres);
        $demand->regions()->attach($regions);
    }

    protected function attachCompanyToSphereAndRegion(\App\Company $company, $spheres, $regions)
    {
        $company->spheres()->attach($spheres);
        $company->regions()->attach($regions);
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

    /**
     * @param $countItems
     * @param array $data
     * @param array $ItemData
     * @return App\Demand\Response
     */
    protected function createResponseWithItems($countItems, $data = [], $ItemData = [])
    {

        $item = factory(\App\Demand\Response::class)->create($data);
        for($j=0; $j<$countItems;$j++) {
            $item->responseItems()->save(factory(\App\Demand\ResponseItem::class)->make($ItemData));
        }



        return $item;
    }

    protected function createDemandWithItems($countItems, $data = [], $demandItemData = [])
    {
        if (isset($data['spheres'])) {
            $spheres = $data['spheres'];
            unset($data['spheres']);
        }
        if (isset($data['regions'])) {
            $regions = $data['regions'];
            unset($data['regions']);
        }


        $demand = factory(\App\Demand\Demand::class)->create($data);
        for($j=0; $j<$countItems;$j++) {
            $demand->demandItems()->save(factory(\App\Demand\DemandItem::class)->make($demandItemData));
        }

        if (isset($spheres)) {
            $demand->spheres()->attach($spheres);
        }
        if (isset($regions)) {
            $demand->regions()->attach($regions);
        }


        return $demand;
    }

}
