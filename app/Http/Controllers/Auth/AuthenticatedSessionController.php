<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Vérifie les identifiants (LoginRequest)
        $request->authenticate();

        // Regénère la session pour éviter la fixation de session
        $request->session()->regenerate();

        // Redirection avec message
        return redirect()->intended(route('dashboard', absolute: false))
            ->with('success', 'Connexion réussie ! Bienvenue sur Culture Bénin.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // Invalide la session actuelle
        $request->session()->invalidate();

        // Regénère le token CSRF
        $request->session()->regenerateToken();

        // Redirection vers la page d’accueil
        return redirect('/')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
