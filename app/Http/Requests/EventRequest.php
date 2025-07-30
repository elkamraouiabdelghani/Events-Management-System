<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if($this->isMethod('post')){
            return [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'region_id' => 'required|exists:regions,id',
                'city_id' => 'required|exists:cities,id',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i',
                'place' => 'required|string|max:255',
                'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'organizer_title' => 'required_if:role,admin',
            ];
        }
        if($this->isMethod('put') || $this->isMethod('patch')){
            return [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category_id' => 'required|exists:categories,id',
                'region_id' => 'required|exists:regions,id',
                'city_id' => 'required|exists:cities,id',
                'date' => 'required|date',
                'time' => 'required|date_format:H:i:s',
                'place' => 'required|string|max:255',
                'event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre est requis',
            'title.string' => 'Le titre doit être une chaîne de caractères',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères',
            'description.required' => 'La description est requise',
            'description.string' => 'La description doit être une chaîne de caractères',
            'category_id.required' => 'La catégorie est requise',
            'category_id.exists' => 'La catégorie n\'existe pas',
            'region_id.required' => 'La région est requise',
            'region_id.exists' => 'La région n\'existe pas',
            'city_id.required' => 'La ville est requise',
            'city_id.exists' => 'La ville n\'existe pas',
            'date.required' => 'La date est requise',
            'date.date' => 'La date doit être une date valide',
            'time.required' => 'L\'heure est requise',
            'time.date_format' => 'L\'heure doit être au format HH:MM',
            'place.required' => 'Le lieu est requise',
            'place.string' => 'Le lieu doit être une chaîne de caractères',
            'place.max' => 'Le lieu ne doit pas dépasser 255 caractères',
            'event_image.image' => 'L\'image doit être une image',
            'event_image.mimes' => 'L\'image doit être au format JPEG, PNG, JPG, GIF ou SVG',
            'event_image.max' => 'L\'image ne doit pas dépasser 2048 ko',
            'organizer_title.required_if' => 'Le nom de l\'organisateur est requis pour les administrateurs',
        ];
    }
}
