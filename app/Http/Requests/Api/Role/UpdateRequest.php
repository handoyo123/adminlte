<?php

namespace App\Http\Requests\Api\Role;

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
     */
    public function rules(): array
    {
        $convertedId = Hashids::decode($this->route('role'));
        $id = $convertedId[0];

        return [
            'name' => 'required|unique:roles,name,' . $id,
            'display_name' => 'required',
            'permissions' => 'required'
        ];
    }
}
