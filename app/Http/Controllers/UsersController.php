<?php

namespace App\Http\Controllers;

use App\Jobs\CreateDraftResponseForCompanyJob;
use App\Services\UserService;
use App\Http\Requests\User\CreateUserRequest;

use Dingo\Api\Routing\Helpers;
use Swagger\Annotations as SWG;
/**
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
     * @SWG\Post(
     *     path="/users",
     *     summary="Create user(init registration -- after need confirm)",
     *     tags={"user"},
     *     description="",
     *     operationId="createUser",
     *     @SWG\Parameter(
     *          name="User",
     *          in="body",
     *          @SWG\Schema(ref="#/definitions/CreateUserRequest")
     *      ),
     *     @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *         @SWG\Header(header="location", type="string", description="/users/1")
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         ref="#/responses/NotFoundResponse"
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         ref="#/responses/NotAuthResponse"
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         ref="#/responses/DefaultErrorResponse"
     *     ),
     *
     * )
     */
    public function store(CreateUserRequest $request)
    {
        $user = $this->userService->createUser($request);
        dispatch(new CreateDraftResponseForCompanyJob($user->company));
        return $this->response->created('/users/' . $user->id);
    }

}
