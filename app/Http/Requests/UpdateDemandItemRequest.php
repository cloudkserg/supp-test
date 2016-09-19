<?php
/**
 * Created by PhpStorm.
 * User: kirya
 * Date: 18.09.16
 * Time: 12:50
 */

namespace App\Http\Requests;

use App\Demand\DemandItem;
use App\Services\DemandItemService;

class UpdateDemandItemRequest extends ApiRequest
{
    /**
     * @var DemandItem
     */
    private $item;

    /**
     * @var DemandItemService
     */
    private $demandItemService;

    public function __construct(array $query = array(), array $request = array(), array $attributes = array(), array $cookies = array(), array $files = array(), array $server = array(), $content = null)
    {
        $this->demandItemService = new DemandItemService();
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content); // TODO: Change the autogenerated stub
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->getDemandItem());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'response_item_id' => 'int|required'
        ];
    }

    /**
     * @return DemandItem
     */
    public function getDemandItem()
    {
        if (!isset($this->item)) {
            $this->item = $this->demandItemService->findItem((int)$this->route('id'));
        }
        return $this->item;
    }


}