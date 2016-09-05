<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UserCreateRequest;
use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Session;


class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    private $_userService;


    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_userService = new UserService();
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }


    public function register(UserCreateRequest $request)
    {
        $this->_userService->createUser($request);

        Session::flash('success', 'Пользователь создан. Вам отправлено письмо с подтверждением.');
        return redirect($this->redirectTo);

    }


    public function confirm($confirmation_code)
    {
        if (!$confirmation_code) {
            abort('404');
        }
        $user = $this->_userService->confirmUser($confirmation_code);
        \Auth::login($user);

        return redirect($this->redirectTo);
    }



    /**
     * @param Request $request
     * @return array
     */
    protected function getCredentials(Request $request)
    {
        $attrs = $request->only($this->loginUsername(), 'password');
        $attrs['confirmed'] = true;
        return $attrs;
    }


}
