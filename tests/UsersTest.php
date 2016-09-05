<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UsersTest extends TestCase
{
    use DatabaseMigrations;


    public function testCreateErrorApi()
    {
        $this->post('/users')
            ->seeJson([
                ''
            ]);


    }


}
