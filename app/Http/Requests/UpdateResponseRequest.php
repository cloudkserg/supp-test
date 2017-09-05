<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 13.09.16
 * Time: 16:24
 */

namespace App\Http\Requests;


use App\Http\Requests\ApiRequest;
use App\Demand\Response;
use App\Services\ResponseService;
use App\Type\ResponseStatus;
use Carbon\Carbon;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @SWG\Definition(
 *      definition="UpdateResponseRequest",
 *      required={"responseItems"},
 *      @SWG\Property(property="deliveryType", type="string"),
 *      @SWG\Property(property="number", type="string"),
 *      @SWG\Property(property="desc", type="string"),
 *      @SWG\Property(
 *          property="responseItems",
 *          type="array",
 *          @SWG\Items(
 *              type="object",
 *              required={"demandItemId", "price"},
 *              @SWG\Property(property="id", type="integer", description="id for change and null for new"),
 *              @SWG\Property(property="demandItemId", type="integer"),
 *              @SWG\Property(property="price", type="number")
 *          )
 *      )
 * )
 * Class UpdateResponseRequest
 * @package App\Http\Requests
 */
class UpdateResponseRequest extends ApiRequest
{
    /**
     * @var Response
     */
    private $item;

    /**
     * @var ResponseService
     */
    private $responseService;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        $this->responseService = new ResponseService();
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content); // TODO: Change the autogenerated stub
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->getResponse());
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'number' => 'string',
            'deliveryType' => 'string',
            'desc' => 'string',

            'responseItems' => 'array',
            'responseItems.*.id' => 'integer',
            'responseItems.*.demandItemId' => 'integer',
            'responseItems.*.price' => 'numeric'
        ];

        return $rules;
    }


    /**
     * @return Response
     */
    public function getResponse()
    {
        if (!isset($this->item)) {
            $this->item = $this->responseService->findItem((int)$this->route('id'));
            if (!isset($this->item)) {
                throw new NotFoundHttpException('Not found item');
            }
        }
        return $this->item;
    }



}

