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

class UpdateResponseRequest extends ApiRequest
{
    /**
     * @var Response
     */
    private $item;

    /**
     * @var ResponseService
     */
    private $demandService;

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
        return [
            'response_id' => 'integer|required',
            'status' => 'string',
            'delivery_type' => 'string',
            'responseItems' => 'array|required',
            'responseItems.*.id' => 'integer',
            'responseItems.*.demand_item_id' => 'integer|required',
            'responseItems.*.price' => 'numeric|required'
        ];
    }


    /**
     * @return Response
     */
    public function getResponse()
    {
        if (!isset($this->item)) {
            $this->item = $this->responseService->findItem($this->response_id);
        }
        return $this->item;
    }



}

