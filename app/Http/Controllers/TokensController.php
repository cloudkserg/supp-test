<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.09.16
 * Time: 21:47
 */

namespace App\Http\Controllers;


use App\Services\BadTokenException;
use App\Services\TokenService;
use Dingo\Api\Routing\Helpers;


use App\Http\Requests\Token\CreateTokenRequest;
use Illuminate\Http\Request;
use Swagger\Annotations as SWG;

class TokensController extends Controller
{
    use Helpers;


    /**
     * @SWG\Post(
     *     path="/tokens",
     *     summary="Create token for authorization",
     *     tags={"token"},
     *     description="",
     *     operationId="createToken",
     *     @SWG\Parameter(
     *          name="email",
     *          type="string",
     *          in="formData",
     *          required=true,
     *          description="email",
     *          maxLength=255
     *      ),
     *     @SWG\Parameter(
     *          name="password",
     *          type="string",
     *          in="formData",
     *          required=true,
     *          description="password",
     *          maxLength=255
     *      ),
     *     @SWG\Response(
     *         response=201,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="token", type="string")
     *         )
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
    public function store(CreateTokenRequest $request)
    {
        $service = new TokenService();
        $token = $service->createToken($request->email, $request->password);

        // all good so return the token
        return $this->response->created(null, compact('token'));
    }
    /**
     * @SWG\Put(
     *     path="/tokens",
     *     summary="Refresh token for authorization",
     *     tags={"token"},
     *     description="",
     *     operationId="updateToken",
     *     @SWG\Parameter(
     *          name="token",
     *          type="string",
     *          in="formData",
     *          required=true,
     *          description="working token",
     *          maxLength=255
     *      ),
     *     @SWG\Response(
     *         response=202,
     *         description="successful operation",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="token", type="string")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="Bad: Token not provided",
     *         @SWG\Schema(ref="#/definitions/ErrorModel")
     *     ),
     *     @SWG\Response(
     *         response=403,
     *         description="Forbidden: invalid token provided",
     *         @SWG\Schema(ref="#/definitions/ErrorModel")
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
    public function update(Request $request)
    {
        $token  =   $request->get('token');
        if(!$token)
        {
            return $this->response->errorBadRequest('Token not provided');
        }

        $service = new TokenService();
        try{
            $service->refreshToken($request->token);
        } catch (BadTokenException $e) {
            return $this->response->errorForbidden('Invalid token provided');
        }

        return $this->response->accepted(null, compact('token'));
    }

    public function test()
    {
        return $this->response->noContent();
    }
}