<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 01.09.16
 * Time: 17:27
 */

namespace App\Services;
use App\Company;
use App\Http\Requests\User\CreateUserRequest;

class CompanyService
{

    /**
     * @param CreateUserRequest $request
     * @return Company
     */
    public function createCompany(CreateUserRequest $request)
    {
        $company = new Company();
        $company->title = $request->company_title;
        $company->save();
        return $company;
    }

}