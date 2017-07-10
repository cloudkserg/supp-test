<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 12:58
 */

namespace App\Services;

use App\Http\Requests\User\CreateUserRequest;
use App\Repository\UserRepository;
use App\User;
use App\Events\RegisterUserEvent;


class UserService
{
    const DEFAULT_NAME = 'default_user';

    const CONFIRMATION_LENGTH = 30;
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     *
     */
    public function __construct()
    {
        $this->companyService = new CompanyService();
        $this->userRepository = new UserRepository();
    }

    /**
     * @return User
     */
    public function getStubUser()
    {
        return factory(User::class, 'stub')->make();
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
            $company = $this->companyService->createCompany($request);

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $this->encryptPassword($request->password);
            $user->company_id = $company->id;
            $user->confirmation_code = \str_random(self::CONFIRMATION_LENGTH);
            $user->saveOrFail();

        } catch(\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();

        \Event::fire(new RegisterUserEvent($user));
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

    public function confirmUser($code)
    {
        $user = $this->userRepository->findByConfirmationCode($code);
        if (!$user) {
            throw new \Exception('Пользователя не нашли.');
        }
        $user->confirmed = true;
        $user->confirmation_code = null;
        $user->saveOrFail();

        return $user;
    }

}