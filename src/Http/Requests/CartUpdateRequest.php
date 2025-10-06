<?php

declare(strict_types=1);

namespace Mortezaa97\Orders\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartUpdateRequest extends FormRequest
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
            'storage_id' => 'required_unless:product_id,null',
            'product_id' => 'required_unless:product_id,null',
            'count' => 'required_unless:product_id,null',
        ];
    }
}
