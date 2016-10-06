<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\User\ConfirmationRequest;
use Dingo\Api\Routing\Helpers;
use Swagger\Annotations\Schema;

class ConfirmationsController extends Controller
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
     *     path="/users/{user_id}/confirmations",
     *     summary="Confirm user registration",
     *     tags={"user"},
     *     description="",
     *     operationId="confirmUserRegistration",
     *      @SWG\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="User id",
     *         required=true,
     *         type="integer",
     *      ),
     *     @SWG\Parameter(
     *         name="ConfirmationRequest",
     *         in="body",
     *         @SWG\Schema(ref="#/definitions/ConfirmationRequest")
     *     ),
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
     * )
     */
    public function store($user_id, ConfirmationRequest $request)
    {
        $this->userService->confirmUser($user_id, $request->confirmation_code);
        return $this->response->created('/users/' . $user_id);
    }

}
