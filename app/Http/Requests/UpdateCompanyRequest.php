<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 10.07.17
 * Time: 10:07
 */

namespace App\Http\Requests;

use App\Company;
use App\Services\CompanyService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


/**
 * @SWG\Definition(
 *      definition="UpdateCompanyRequest",
 *      required={"title"},
 *      @SWG\Property(property="title", type="string", maxLength=255, description="title unique for company"),
 *      @SWG\Property(property="desc", type="string", description="desc"),
 *      @SWG\Property(property="founded", type="string", description="founded string" ),
 *      @SWG\Property(property="site", type="string", description="site" ),
 *      @SWG\Property(property="address", type="string", description="address" ),
 *      @SWG\Property(property="email", type="string", description="email" ),
 *      @SWG\Property(property="phone", type="string", description="phone" ),
 *      @SWG\Property(
 *         property="regions",
 *         description="regions",
 *         type="array",
 *         @SWG\Items(type="string", description="region")
 *      ),
 *      @SWG\Property(
 *         property="spheres",
 *         description="spheres",
 *         type="array",
 *         @SWG\Items(type="string", description="sphere")
 *      ),
 * )
 *
 *
 *
 * Class UpdateCompanyRequest
 * @package App\Http\Requests
 *
 * @property string $company_title
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property int[] $spheres
 * @property int[] $regions
 *
 */
class UpdateCompanyRequest extends ApiRequest
{

    /**
     * @var Company
     */
    private $item;

    /**
     * @var CompanyService
     */
    private $service;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        $this->service = new CompanyService();
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content); // TODO: Change the autogenerated stub
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->getCompany());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|required|max:255|unique:companies,title,' . (int)$this->route('id'),
            'founded' => 'string',
            'site' => 'string',
            'desc' => 'string',
            'email' => 'email',
            'phone' => 'string',
            'address' => 'string',
            'regions' => 'array|required',
            'regions.*' => 'integer',
            'spheres' => 'array|required',
            'spheres.*' => 'integer',
        ];
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        if (!isset($this->item)) {
            $this->item = $this->service->findItem((int)$this->route('id'));
            if (!isset($this->item)) {
                throw new NotFoundHttpException('Not found item');
            }
        }
        return $this->item;
    }

}