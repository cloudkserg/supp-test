<?php

namespace App\Http\Controllers;

use App\Jobs\CreateDraftResponseForCompanyJob;
use App\Services\UserService;
use App\Http\Requests\User\CreateUserRequest;

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
    private $userService;


    /**
     *
     */
    public function __construct()
    {
        $this->userService = new UserService();
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
        $user = $this->userService->createUser($request);
        dispatch(new CreateDraftResponseForCompanyJob($user->company));
        return $this->response->created('/users/' . $user->id);
    }

}
