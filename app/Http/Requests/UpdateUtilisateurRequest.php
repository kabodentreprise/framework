<?php
// app/Http/Requests/UpdateUtilisateurRequest.php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUtilisateurRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Admin peut modifier tous, utilisateurs peuvent modifier leur propre profil
        $utilisateurId = $this->route('utilisateur');
        return auth()->check() &&
               (auth()->user()->id_role == 1 || auth()->id() == $utilisateurId);
    }

    public function rules(): array
    {
        $utilisateurId = $this->route('utilisateur');

        return [
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email' => 'required|email:rfc,dns|max:255|unique:utilisateurs,email,' . $utilisateurId,
            'sexe' => 'required|in:H,F,M,Autre',
            'date_naissance' => [
                'required',
                'date',
                'before:today',
                'after:1900-01-01',
            ],
            'statut' => 'sometimes|in:actif,inactif,suspendu,restreint,banni',
            'id_role' => 'sometimes|exists:roles,id',
            'id_langue' => 'nullable|exists:langues,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120|dimensions:max_width=2000,max_height=2000',
        ];
    }

    public function messages(): array
    {
        return [
            'date_naissance.before' => 'La date de naissance doit être antérieure à aujourd\'hui',
            'photo.max' => 'La photo ne doit pas dépasser 5MB',
        ];
    }
}
