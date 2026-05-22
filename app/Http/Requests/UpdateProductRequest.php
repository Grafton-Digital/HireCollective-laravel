<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $boutiqueId = $this->user()->boutique_id;
        $productId = $this->route('product')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('products')->where('boutique_id', $boutiqueId)->ignore($productId)],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'required_if:is_variable,false', 'numeric', 'min:0'],
            'is_variable' => ['required', 'boolean'],
            'is_available' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            'colours' => ['nullable', 'array'],
            'colours.*' => ['exists:colours,id'],
            'occasions' => ['nullable', 'array'],
            'occasions.*' => ['exists:occasions,id'],
            'variants' => ['nullable', 'required_if:is_variable,true', 'array'],
            'variants.*.size' => ['required_with:variants', 'string', 'max:50'],
            'variants.*.price' => ['required_with:variants', 'numeric', 'min:0'],
            'variants.*.is_available' => ['required_with:variants', 'boolean'],
        ];
    }
}
