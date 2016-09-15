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


class TokensController extends Controller
{
    use Helpers;


    public function store(CreateTokenRequest $request)
    {
        $service = new TokenService();
        $token = $service->createToken($request->email, $request->password);

        // all good so return the token
        return $this->response->created(null, compact('token'));
    }

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