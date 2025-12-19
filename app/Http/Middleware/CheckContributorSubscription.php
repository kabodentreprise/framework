<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Achats;

class CheckContributorSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Si c'est un Admin (1) ou Modérateur (2), pas besoin d'abonnement
        // Note: ID 3 est maintenant Contributeur selon seeder précédent
        if ($user->id_role === 1 || $user->id_role === 2) {
            return $next($request);
        }

        // On vérifie s'il a payé l'abonnement
        $hasSubscription = Achats::where('id_utilisateur', $user->id)
            ->where('type', 'abonnement')
            ->where('statut', 'payé')
            ->exists();

        // Si l'utilisateur n'a pas d'abonnement actif
        if (!$hasSubscription) {
            // On autorise l'accès à la page de paiement et au callback pour éviter une boucle de redirection
            if ($request->routeIs('contributeur.abonnement') || 
                $request->routeIs('contributeur.paiement.initier') || 
                $request->routeIs('contributeur.paiement.callback')) {
                return $next($request);
            }

            // Pour tout autre accès protégé par ce middleware, on redirige vers l'abonnement
            return redirect()->route('contributeur.abonnement')
                ->with('warning', 'Vous devez payer votre abonnement de contributeur (5000 FCFA) pour accéder à ces fonctionnalités.');
        }

        return $next($request);
    }
}
