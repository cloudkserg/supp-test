<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Jobs\CreateDraftResponseForCompanyJob;

class UsersTest extends TestCase
{
    use DatabaseMigrations;


    public function testCreate()
    {
        $this->expectsJobs(CreateDraftResponseForCompanyJob::class);
        $this->post('/api/users', [
                'email' => 'abba@mail.ru',
                'password' => '123456',
                'password_confirmation' => '123456',
                'name' => 'Test user',
                'company_title' => 'Test company'
            ])
            ->seeStatusCode(201)
            ->seeHeader('location', '/users/1');

    }

    public function testErrorValidationPassword()
    {
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
