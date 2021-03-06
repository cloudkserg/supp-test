<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class ConfirmationsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var \App\User
     */
    protected $user;

    /**
     * @var \App\User
     */
    private $confirmatingUser;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        factory(\App\Company::class)->create();
        $this->user = factory(\App\User::class)->create();
        $this->confirmatingUser = factory(\App\User::class, 'confirmating')->create();
    }


    public function testCreate()
    {
        $this->expectsJobs(\App\Jobs\CreateDraftResponseForCompanyJob::class);
        $r = $this->post(
            'api/users/confirmations',
            [
                'confirmationCode' => $this->confirmatingUser->confirmation_code
            ]
        )
            ->assertStatus(201)
            ->assertHeader('location', '/users/' . $this->confirmatingUser->id);
    }

    public function testErrorAlreadyCreating()
    {
        $this->post(
            'api/users/confirmations',
            [
                'confirmationCode' => $this->user->confirmation_code
            ]
        )
            ->assertStatus(422);
    }

    public function testErrorWithoutConfirmationCode()
    {
        $this->post(
            'api/users/confirmations',
            [
            ]
        )
            ->assertStatus(422);
    }

    public function testErrorWithNotRightConfirmationCode()
    {
        $this->post(
            'api/users/confirmations',
            [
                'confirmationCode' => str_random(30)
            ]
        )
            ->assertStatus(500);
    }

}
