<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Jobs\CreateDraftResponseForCompanyJob;
use App\Events\RegisterUserEvent;
class UsersTest extends TestCase
{
    use DatabaseMigrations;


    public function testCreate()
    {
        $this->expectsJobs(CreateDraftResponseForCompanyJob::class);

        $this->expectsEvents(RegisterUserEvent::class);

        $this->createBeforeCompany();

        $spheres = \App\Type\Sphere::take(2)->get();
        $regions = \App\Type\Region::take(2)->get();

        $this->post('/api/users', [
                'email' => 'abba@mail.ru',
                'password' => '123456',
                'password_confirmation' => '123456',
                'name' => 'Test user',
                'company_title' => 'Test company',
                'spheres' => collect($spheres)->pluck('id')->toArray(),
                'regions' => collect($regions)->pluck('id')->toArray()
            ])
            ->seeStatusCode(201)
            ->seeHeader('location', '/users/1');


        $user = \App\User::find(1);
        $this->assertInstanceOf(\App\User::class, $user);
        $company = $user->company;
        $this->assertInstanceOf(\App\Company::class, $company);
        $this->assertCount(2, $company->regions);
        $this->assertCount(2, $company->spheres);
        $this->assertEquals($spheres[0]->id, $company->spheres[0]->id);
        $this->assertEquals($spheres[1]->id, $company->spheres[1]->id);
        $this->assertEquals($regions[1]->id, $company->regions[1]->id);
        $this->assertEquals($regions[1]->id, $company->regions[1]->id);

    }

    public function testErrorWithSpheres()
    {
        $this->doesntExpectEvents(RegisterUserEvent::class);
        $this->post('/api/users', [
            'email' => 'abba@mail.ru',
            'password' => '123456',
            'password_confirmation' => '123456',
            'name' => 'Test user',
            'compay_title' => 'Test company'
        ])->seeStatusCode(422);
    }

    public function testErrorValidationPassword()
    {
        $this->doesntExpectEvents(RegisterUserEvent::class);
        $this->post('/api/users', [
            'email' => 'abba@mail.ru',
            'password' => '123456',
            'password_confirmation' => '1234567',
            'name' => 'Test user',
            'company_title' => 'Test company'
        ])->seeStatusCode(422);
    }

    public function testErrorValidationNotCompany()
    {
        $this->post('/api/users', [
            'email' => 'abba@mail.ru',
            'password' => '123456',
            'password_confirmation' => '123456',
            'name' => 'Test user'
        ])->seeStatusCode(422);
    }

    public function testErrorValidationNotEmail()
    {
        $this->post('/api/users', [
            'password' => '123456',
            'password_confirmation' => '123456',
            'name' => 'Test user'
        ])->seeStatusCode(422);
    }
}
