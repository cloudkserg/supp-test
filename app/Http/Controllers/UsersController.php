<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\User\CreateUserRequest;

use Dingo\Api\Routing\Helpers;

class UsersController extends Controller
{

    use Helpers;
    /**
     * @var UserService
     */
    private $_userService;


    /**
     *
     */
    public function __construct()
    {
        $this->_userService = new UserService();
    }

    /**
     * @param CreateUserRequest $request
     * @return \Dingo\Api\Http\Response
     * @throws \Exception
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->_userService->createUser($request);
        return $this->response->created(null, $user);
    }

}
