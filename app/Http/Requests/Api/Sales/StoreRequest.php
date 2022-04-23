<?php

namespace App\Http\Requests\Api\Sales;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @noinspection PhpUndefinedFieldInspection
     * @noinspection PhpUndefinedFieldInspection
     */
    public function rules(): array
    {
        $loggedUser = auth('api')->user();

        $rules = [
            'user_id' => 'required',
            'order_status' => 'required',
            'product_items' => 'required'
        ];

        if ($this->invoice_number && $this->invoice_number != '') {
            $rules['invoice_number'] = 'required|unique:orders,invoice_number';
        }

        return $rules;
    }
}
