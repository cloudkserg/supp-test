<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Http\Requests\User\ConfirmationRequest;
use Dingo\Api\Routing\Helpers;

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

    public function store($user_id, ConfirmationRequest $request)
    {
        $this->userService->confirmUser($user_id, $request->confirmation_code);
        return $this->response->created('/users/' . $user_id);
    }

}
