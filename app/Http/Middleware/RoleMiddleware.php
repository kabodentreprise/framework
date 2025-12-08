<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect('login');
        }

        $userRole = $request->user()->id_role;

        // Si aucun rôle n'est passé en paramètre, on suppose que c'est pour l'admin (id 1)
        if (empty($roles)) {
            if ($userRole == 1) {
                return $next($request);
            }
        }
        
        // Si des rôles sont spécifiés
        foreach ($roles as $role) {
            // Mapping des noms de rôles vers les IDs (à ajuster selon votre DB)
            $roleId = match($role) {
                'admin' => 1,
                'moderateur' => 3,
                'contributeur' => 4,
                'editeur' => 5,
                // Ajoutez d'autres mappings ici si nécessaire
                default => null
            };

            if ($userRole == $roleId) {
                return $next($request);
            }
        }

        abort(403, 'Accès non autorisé.');
    }
}
