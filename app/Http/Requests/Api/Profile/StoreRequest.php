<?php

namespace App\Http\Requests\Api\Profile;

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
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'image' => 'image|max:2048'
        ];

        if ($this->password != '') {
            $rules['password'] = 'required|min:6';
        }

        return $rules;
    }
}
