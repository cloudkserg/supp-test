<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 06.09.16
 * Time: 15:41
 */

namespace App\Transformers;

use App\Company;
use League\Fractal\TransformerAbstract;
use Swagger\Annotations as SWG;

/**
 * @SWG\Definition(
 *      definition="CompanyModel",
 *      @SWG\Property(property="id", type="integer"),
 *      @SWG\Property(property="title", type="string"),
 *      @SWG\Property(property="site", type="string"),
 *      @SWG\Property(property="address", type="string"),
 *      @SWG\Property(property="founded", type="string"),
 *      @SWG\Property(property="desc", type="string"),
 *      @SWG\Property(
 *          property="regions",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/RegionModel")
 *      ),
 *      @SWG\Property(
 *          property="spheres",
 *          type="array",
 *          @SWG\Items(ref="#/definitions/SphereModel")
 *      ),
 * )
 * Class CompanyTransformer
 * @package App\Transformers
 */
class CompanyTransformer extends TransformerAbstract
{

    public function includeSpheres(Company $company)
    {
        return $this->collection($company->spheres, new SphereTransformer());
    }

    public function includeRegions(Company $company)
    {
        return $this->collection($company->regions, new RegionTransformer());
    }

    /**
     *
     * @return $this
     */
    public function addSpheres()
    {
        $this->defaultIncludes[] = 'spheres';
        return $this;
    }

    /**
     * @return $this
     */
    public function addRegions()
    {
        $this->defaultIncludes[] = 'regions';
        return $this;
    }

    public function transform(Company $company)
    {
        return [
            'id' => (int)$company->id,
            'title' => $company->title,
            'founded' => $company->founded,
            'site' => $company->site,
            'address' => $company->address,
            'desc' => $company->desc
        ];
    }

}
