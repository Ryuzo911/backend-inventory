<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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

    public function prepareForValidation(): void
    {
        $this->merge([
            'role' => $this->input('role', 'user'), // Default role is 'user' if not provided
        ]);
    }
    public function rules(): array
    {
        return [
            "name"=> "required|string",
            "email"=> "required|email|",
            "password"=> "required|min:6|max:255",
            // "role"=> "required|in:admin,user,owner",

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email is invalid',
            'password.required' => 'Password is required',
            'password.min' => 'Password is minimum 6 characters',
            'password.max' => 'Password is maximum 255 characters',
            // 'role.required' => 'Role is required',
            // 'role.in' => 'Role is invalid',

        ];
    }
}