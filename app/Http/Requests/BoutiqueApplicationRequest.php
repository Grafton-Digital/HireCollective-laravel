<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class BoutiqueApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:boutiques,name'],
            'logo' => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,webp,avif,svg', 'max:5120'],
            'bio' => ['required', 'string', 'max:1000'],
            'region' => ['required', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'social_links' => ['nullable', 'array', 'max:5'],
            'social_links.*.platform' => ['required_with:social_links.*.handle', 'nullable', 'string', 'in:instagram,tiktok,facebook,twitter,threads'],
            'social_links.*.handle' => ['required_with:social_links.*.platform', 'nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)->letters()->numbers()->mixedCase()],
        ];
    }
}
