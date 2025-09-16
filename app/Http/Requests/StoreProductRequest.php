<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            "name" => "required|string",
            "category_id" => "required|exists:categories,id",
            "stock" => "required|integer",
            "image_url" => "nullable|image|mimes:jpg,jpeg,png,svg|max:2048",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'category_id.required' => 'A category is required',
            'stock.required'=> 'A stock is required',
            'category_id.exists' => 'Category not found',
            'image_url.url' => 'Image URL must be a valid URL',
        ];
    }

}