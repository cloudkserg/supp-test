<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateRequestItemRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'string|max:255',
            'count' => 'float',
            'quantity_id' => 'integer'
        ];
    }
}
