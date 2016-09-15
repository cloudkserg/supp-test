<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 12:58
 */

namespace App\Services;

use App\Http\Requests\User\CreateUserRequest;
use App\User;
use App\Events\RegisterUser;


class UserService
{

    const CONFIRMATION_LENGTH = 30;
    /**
     * @var CompanyService
     */
    private $_companyService;

    /**
     *
     */
    public function __construct()
    {
        $this->_companyService = new CompanyService();
    }

    /**
     * @param CreateUserRequest $request
     * @return User
     * @throws \Exception
     */
    public function createUser(CreateUserRequest $request)
    {
        \DB::beginTransaction();
        try {
            $company = $this->_companyService->createCompany($request);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $this->encryptPassword($request->password);
            $user->company_id = $company->id;
            $user->confirmation_code = \str_random(self::CONFIRMATION_LENGTH);
            $user->save();

        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        \Event::fire(new RegisterUser($user));
        return $user;
    }

    /**
     * @param $password
     * @return string
     */
    public function encryptPassword($password)
    {
        return bcrypt($password);
    }

    public function confirmUser($id, $code)
    {
        $user = User::whereConfirmationCode($code)->whereId($id)->first();
        if (!$user) {
            throw new \Exception('Пользователя не нашли.');
        }
        $user->confirmed = true;
        $user->confirmation_code = null;
        $user->save();

        return $user;
    }

}