<?php
// app/Http/Requests/StoreUtilisateurRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUtilisateurRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->id_role == 1; // Admin seulement
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email:rfc,dns|max:255|unique:utilisateurs,email',
            'mot_de_passe' => 'required|confirmed|min:8',
            'sexe' => 'required|in:H,F,M,Autre', // Accepting H and M to be safe, but standardizing on M in view
            'date_naissance' => [
                'required',
                'date',
                'before:today',
                'after:1900-01-01',
            ],
            'statut' => 'required|in:actif,inactif,suspendu,restreint,banni',
            'id_role' => 'required|exists:roles,id',
            'id_langue' => 'nullable|exists:langues,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120|dimensions:max_width=2000,max_height=2000',
        ];
    }

    public function messages(): array
    {
        return [
            'mot_de_passe.required' => 'Le mot de passe est obligatoire',
            'mot_de_passe.confirmed' => 'La confirmation du mot de passe ne correspond pas',
            'mot_de_passe.min' => 'Le mot de passe doit contenir au moins 8 caractères',
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui',
            'date_naissance.after' => 'La date de naissance doit être postérieure au 01/01/1900',
            'photo.max' => 'La photo ne doit pas dépasser 5MB',
            'photo.dimensions' => 'La photo ne doit pas dépasser 2000x2000 pixels',
        ];
    }

    public function attributes(): array
    {
        return [
            'mot_de_passe' => 'mot de passe',
            'date_naissance' => 'date de naissance',
            'id_role' => 'rôle',
            'id_langue' => 'langue',
        ];
    }
}
