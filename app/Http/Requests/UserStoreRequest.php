<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => 'required|string|min:11|max:13|unique:users,phone' ,
            'username' => 'required|string|unique:users,username',
            'name' => 'required|string|min:3',
            'password' => 'required|string|min:8',
            'role' => 'nullable|in:user,admin'
        ];
    }
}
