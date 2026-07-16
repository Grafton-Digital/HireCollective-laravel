<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
            'size' => ['nullable', 'string', 'max:255'],
            'color' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'exists:categories,id'],
            'designer' => ['nullable', 'string', 'max:255'],
            'featured_image' => ['required', 'image', 'max:10240'],
            'gallery' => ['nullable', 'array', 'max:10'],
            'gallery.*' => ['image', 'max:10240'],
            'availability' => ['nullable', 'json'],
        ];
    }
}
