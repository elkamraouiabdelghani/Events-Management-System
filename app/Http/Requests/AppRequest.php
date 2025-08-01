<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if user is authenticated
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();
        
        // Only admin can manage application settings
        return $user->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
            'slider-image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5072',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis',
            'name.string' => 'Le nom doit être une chaîne de caractères',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'slogan.string' => 'Le slogan doit être une chaîne de caractères',
            'slogan.max' => 'Le slogan ne doit pas dépasser 255 caractères',
            'logo.image' => 'Le logo doit être une image',
            'logo.mimes' => 'Le logo doit être au format JPEG, PNG, JPG, GIF ou SVG',
            'logo.max' => 'Le logo ne doit pas dépasser 2048 ko',
            'favicon.image' => 'Le favicon doit être une image',
            'favicon.mimes' => 'Le favicon doit être au format JPEG, PNG, JPG, GIF ou SVG',
            'favicon.max' => 'Le favicon ne doit pas dépasser 1024 ko',
            'slider-image.image' => 'L\'image de la bannière doit être une image',
            'slider-image.mimes' => 'L\'image de la bannière doit être au format JPEG, PNG, JPG, GIF ou SVG',
            'slider-image.max' => 'L\'image de la bannière ne doit pas dépasser 5072 ko',
        ];
    }
}
