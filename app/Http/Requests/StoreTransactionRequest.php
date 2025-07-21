<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
        "product_id" => "required|exists:products,id",
        "type" => "required|in:in,out",
        "quantity" => "required|integer|min:1",
        "created_by" => "required|exists:users,id",
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'A product is required',
            'type.required' => 'A type is required',
            'quantity.required' => 'A quantity is required',
            'created_by.required' => 'A created by is required',
        ];
    }
}