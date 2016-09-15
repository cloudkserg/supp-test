<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class DemandsTest extends TestCase
{
    use DatabaseMigrations;

    private $regions;

    private $spheres;

    private $quantities;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->setAuthToken();
        $this->regions = factory(\App\Type\Region::class, 2)->create()->pluck('id')->toArray();
        $this->spheres = factory(\App\Type\Sphere::class, 2)->create()->pluck('id')->toArray();
        $this->quantities = factory(\App\Type\Quantity::class, 2)->create()->pluck('id')->toArray();



    }



    public function testCreate()
    {
        $faker = Faker\Factory::create();

        $data = [
            'title' => $faker->title,
            'desc' => $faker->text,
            'delivery_date' => $faker->date('d.m.Y'),
            'addition_emails' => [
                $faker->safeEmail,
                $faker->safeEmail
            ],
            'regions' => $faker->randomElements($this->regions),
            'spheres' => $faker->randomElements($this->spheres),
            'demandItems' => [
                [
                    'title' => $faker->title,
                    'count' => $faker->randomFloat(),
                    'quantity_id' => $faker->randomElement($this->quantities)
                ],
                [
                    'title' => $faker->title,
                    'count' => $faker->randomFloat(),
                    'quantity_id' => $faker->randomElement($this->quantities)
                ],
            ]
        ];

        $this->post('/api/demands?token=' . $this->token, $data)
            ->seeStatusCode(201)
            ->seeHeader('location', '/demands/1');
    }

    public function testCreateErrorWithoutDemandItems()
    {
        $faker = Faker\Factory::create();

        $data = [
            'title' => $faker->title,
            'desc' => $faker->text,
            'delivery_date' => $faker->date('d.m.Y'),
            'addition_emails' => [
                $faker->safeEmail,
                $faker->safeEmail
            ],
            'regions' => $faker->randomElements($this->regions),
            'spheres' => $faker->randomElements($this->spheres),
        ];

        $this->post('/api/demands?token=' . $this->token, $data)
            ->seeStatusCode(422);
    }

    public function testCreateAuth()
    {
        $this->post('/api/demands')
            ->seeStatusCode(401);
    }

    public function testIndexActiveAuth()
    {
        $this->get('/api/demands')
            ->seeStatusCode(401);
    }


    public function testIndexActive()
    {
        //create my own active demands
        $this->createBeforeDemand();
        $this->createDemandWithItems(2,1, [
            'status' => \App\Type\DemandStatus::ACTIVE,
            'company_id' => $this->company->id
        ]);
        $this->createDemandWithItems(1,2, [
            'status' => \App\Type\DemandStatus::ACTIVE,
            'company_id' => $this->company->id
        ]);

        $this->createDemandWithItems(1,1, [
            'status' => \App\Type\DemandStatus::ARCHIVED,
            'company_id' => $this->company->id
        ]);
        $company = factory(\App\Company::class)->create();
        $this->createDemandWithItems(1,1, [
            'status' => \App\Type\DemandStatus::ACTIVE,
            'company_id' => $company->id
        ]);


        $r = $this->get('/api/demands?token=' . $this->token)
            ->seeStatusCode('200');
        $data = json_decode($r->response->content())->data;
        $this->assertCount(3, $data);
        $this->assertCount(1, $data[0]->demandItems->data);
        $this->assertCount(2, $data[2]->demandItems->data);
        $r
            ->seeJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'demandItems' => [
                            'data' => [
                                '*' => [
                                    'id',
                                    'status',
                                    'quantityTitle',
                                    'count',
                                    'title'
                                ]
                            ]
                        ]
                    ]
                ]
           ]);


    }




}
