<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;


class TokensTest extends TestCase
{
    use DatabaseMigrations;

    const PASSWORD = '123456';

    /**
     * @var \App\User
     */
    protected $user;

    /**
     * @var \App\User
     */
    private $confirmUser;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        factory(\App\Company::class)->create();
        $userService = new \App\Services\UserService();
        $this->user = factory(\App\User::class)->create([
            'password' => $userService->encryptPassword(self::PASSWORD)
        ]);

        $this->confirmUser = factory(\App\User::class, 'confirmating')->create([
            'password' => $userService->encryptPassword(self::PASSWORD)
        ]);
    }


    public function testCreate()
    {
        $r = $this->post('/api/tokens', [
                'email' => $this->user->email,
                'password' => self::PASSWORD
            ])
            ->seeStatusCode(201)
            ->seeJsonStructure([
                'token'
            ]);

        $token = json_decode($r->response->content())->token;
        $payload = JWTAuth::setToken($token)->getPayload();
        $this->assertEquals($this->user->id, $payload->get('id'));
        $this->assertEquals($this->user->company->title, $payload->get('company_title'));
        $this->assertEquals($this->user->company->id, $payload->get('company_id'));
    }

    public function testErrorWithoutPassword()
    {
        $this->post('/api/tokens', [
            'email' => $this->user->email
        ])
            ->seeStatusCode(422);
    }

    public function testErrorWithoutEmail()
    {
        $this->post('/api/tokens', [
                'password' => self::PASSWORD
        ])
            ->seeStatusCode(422);
    }

    public function testErrorWithNotRight()
    {
        $this->post('/api/tokens', [
            'email' => $this->user->email,
            'password' => '1234567'
        ])
            ->seeStatusCode(401);
    }

    public function testErrorConfirm()
    {
        $this->post('/api/tokens', [
            'email' => $this->confirmUser->email,
            'password' => self::PASSWORD
        ])
            ->seeStatusCode(401);
    }


    public function testAuth()
    {
        $r = $this->post('/api/tokens', [
            'email' => $this->user->email,
            'password' => self::PASSWORD
        ]);
        $token = json_decode($r->response->content())->token;

        $this->get('/api/tokens/test?token=' . $token)
            ->seeStatusCode(204);

    }

    public function testNotAuth()
    {
        $token = str_random(7);

        $this->get('/api/tokens/test?token=' . $token)
            ->seeStatusCode(401);

    }

    public function testNotAuthEmpty()
    {
        $this->get('/api/tokens/test')
            ->seeStatusCode(401);
    }

    public function testUpdate()
    {
        $r = $this->post('/api/tokens', [
            'email' => $this->user->email,
            'password' => self::PASSWORD
        ]);
        $token = json_decode($r->response->content())->token;
        $this->put('/api/tokens?token=' . $token)
            ->seeStatusCode(202)
            ->seeJsonStructure([
                'token'
            ]);
    }

    public function testUpdateError()
    {
        $token =  str_random(7);
        $this->put('/api/tokens?token=' . $token)
            ->seeStatusCode(403);
    }

    public function testUpdateErrorEmpty()
    {
        $token =  str_random(7);
        $this->put('/api/tokens')
            ->seeStatusCode(400);
    }


    public function testDeleteNotAuth()
    {
        $token = 'adasdas';
        $r = $this->delete('/api/tokens/' . $token . '?token=' . $token)
            ->seeStatusCode(401);
    }

    public function testDelete()
    {
        $r = $this->post('/api/tokens', [
            'email' => $this->user->email,
            'password' => self::PASSWORD
        ])
            ->seeStatusCode(201)
            ->seeJsonStructure([
                'token'
            ]);

        $token = json_decode($r->response->content())->token;

        $r = $this->delete('/api/tokens/' . $token . '?token=' . $token)
            ->seeStatusCode(202);

//        $this->get('/api/demands?token=' . $token)
//            ->seeStatusCode(401);
    }

}
