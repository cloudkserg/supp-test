<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 05.09.16
 * Time: 21:54
 */

namespace App\Services;

use App\Company;
use Auth;
use App\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class BadTokenException extends \Exception {}

class TokenService
{

    public function createToken($email, $password)
    {
        $token = null;
        try {
            if (!Auth::attempt(['email' => $email, 'password' => $password, 'confirmed' => true])) {
                throw new UnauthorizedHttpException("Email address / password do not match");
            }
            $user = Auth::getUser();
            if (!isset($user)) {
                throw new UnauthorizedHttpException("Email address / password do not match");
            }

            /**
             * @var User $user
             */
            $token = JWTAuth::fromUser($user, [
                'id' => $user->id,
                'company' => $user->company->title
            ]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            throw new HttpException("Unable to login");
        }

        return $token;
    }

    public function refreshToken($token)
    {
        try {
            $token = JWTAuth::refresh($token);
        }
        catch(TokenInvalidException $e) {
            throw new BadTokenException($e->getMessage());
        }
        return $token;
    }

}
