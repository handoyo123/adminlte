<?php

namespace App\Http\Requests\Api\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
     */
    public function rules(): array
    {
        $loggedUser = auth('api')->user();

        $rules = [
            'phone' => [
                'numeric',
                Rule::unique('users', 'phone')->where(function ($query) {
                    return $query->where('user_type', 'users');
                })
            ],
            'name' => 'required',
            'email' => [
                'required', 'email',
                Rule::unique('users', 'email')->where(function ($query) {
                    return $query->where('user_type', 'users');
                })
            ],
            'status' => 'required',
            'password' => 'required|min:8',
        ];

        if ($loggedUser->hasRole('admin')) {
            $rules['role_id'] = 'required';
        }

        return $rules;
    }
}
