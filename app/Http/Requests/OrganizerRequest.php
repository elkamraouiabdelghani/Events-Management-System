<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizerRequest extends FormRequest
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
        
        // Only admin can manage organizers
        if ($user->role === 'admin') {
            return true;
        }
        
        // Organizer can update their own profile
        if ($user->role === 'organizer' && $user->organizer) {
            if ($this->isMethod('put') || $this->isMethod('patch')) {
                $organizerId = $this->route('organizer');
                return $organizerId && $organizerId == $user->organizer->id;
            }
        }
        
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
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'title' => 'required|string|max:255',
                'phone_numbre' => 'nullable|string|max:10',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'existing_organizer_id' => 'nullable|exists:organizers,id',
            ];
        }
        if($this->isMethod('put') || $this->isMethod('patch')){
            return [
                'title' => 'required|string|max:255',
                'phone_numbre' => 'nullable|string|max:10',
                'description' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }

        return [];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis',
            'name.string' => 'Le nom doit être une chaîne de caractères',
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères',
            'email.required' => 'L\'email est requis',
            'email.email' => 'L\'email doit être une adresse email valide',
            'email.unique' => 'L\'email existe déjà',
            'password.required' => 'Le mot de passe est requis',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'title.required' => 'Le titre est requis',
            'title.string' => 'Le titre doit être une chaîne de caractères',
            'title.max' => 'Le titre ne doit pas dépasser 255 caractères',
            'phone_numbre.string' => 'Le numéro de téléphone doit être une chaîne de caractères',
            'phone_numbre.max' => 'Le numéro de téléphone ne doit pas dépasser 10 caractères',
            'description.string' => 'La description doit être une chaîne de caractères',
            'description.max' => 'La description ne doit pas dépasser 255 caractères',
            'image.image' => 'L\'image doit être une image valide',
            'image.mimes' => 'L\'image doit être au format jpeg, png, jpg, gif ou svg',
            'image.max' => 'L\'image ne doit pas dépasser 2Mo',
            'existing_organizer_id.exists' => 'L\'organisateur sélectionné n\'existe pas',
        ];
    }
}
