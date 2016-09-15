<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\User\CreateUserRequest;

use App\Transformers\UserTransformer;
use Dingo\Api\Routing\Helpers;

/**
 * @Resource("Users")
 */
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
	 * Register user
	 *
	 * Register a new user with a `username` and `password`.
	 *
	 * @Post("/")
	 */
    public function store(CreateUserRequest $request)
    {
        $user = $this->_userService->createUser($request);
        return $this->response->created('/users/' . $user->id);
    }

}
