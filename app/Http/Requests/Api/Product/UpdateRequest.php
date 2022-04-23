<?php

namespace App\Http\Requests\Api\Product;

use Illuminate\Foundation\Http\FormRequest;
use Vinkla\Hashids\Facades\Hashids;

class UpdateRequest extends FormRequest
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
        $convertedId = Hashids::decode($this->route('product'));
        $id = $convertedId[0];

        $rules = [
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $id,
            'barcode_symbology' => 'required',
            'item_code' => 'required|unique:products,item_code,' . $id,
            'category_id' => 'required',
            'purchase_price' => 'required|gt:0',
            'sales_price' => 'required|gt:0|gte:purchase_price',
            'unit_id' => 'required'
        ];

        // If purchase or sales includes tax
        if ($this->purchase_tax_type == 'inclusive' || $this->sales_tax_type == 'inclusive') {
            $rules['tax_id'] = 'required';
        }

        return $rules;
    }
}
