<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 18.09.16
 * Time: 12:50
 */

namespace App\Http\Requests;

use App\Demand\Demand;
use App\Services\DemandService;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @SWG\Definition(
 *      definition="UpdateDemandRequest",
 *      @SWG\Property(
 *         property="number",
 *         description="number demand",
 *         type="string",
 *      )
 * )
 * Class UpdateDemandRequest
 * @package App\Http\Requests
 */
class UpdateDemandRequest extends ApiRequest
{
    /**
     * @var Demand
     */
    private $item;

    /**
     * @var DemandService
     */
    private $demandService;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        $this->demandService = new DemandService();
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content); // TODO: Change the autogenerated stub
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->getDemand());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'number' => 'string'
        ];
    }

    /**
     * @return Demand
     */
    public function getDemand()
    {
        if (!isset($this->item)) {
            $this->item = $this->demandService->findItem((int)$this->route('id'));
            if (!isset($this->item)) {
                throw new NotFoundHttpException('Not found item');
            }
        }
        return $this->item;
    }


}