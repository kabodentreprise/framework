<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utilisateurs;
use App\Models\Langues;
use App\Models\Regions;
use App\Models\Contenus;
use App\Models\Commentaires;
use App\Models\Medias;
use Carbon\Carbon;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $stats = [
                'total_users'         => Utilisateurs::count(),
                'users_actifs'        => Utilisateurs::where('statut', 'actif')->count(),
                'users_suspendus'     => Utilisateurs::where('statut', 'suspendu')->count(),
                'users_restreints'    => Utilisateurs::where('statut', 'restreint')->count(),
                'total_langues'       => Langues::count(),
                'total_regions'       => Regions::count(),
                'total_contenus'      => Contenus::count(),
                'total_commentaires'  => Commentaires::count(),
                'total_medias'        => Medias::count(),
                'nouveaux_utilisateurs' => Utilisateurs::whereDate('created_at', today())->count(),
                'pending_content'     => Contenus::where('statut', 'en_attente')->count(),
                'total_languages'     => Langues::count(),
                'storage_used'        => '45%', // Simulée pour l'instant
                'total_media'         => Medias::count(),
                'today_visits'        => rand(100, 500), // Simulée
            ];

            // Données pour les graphiques
            try {
                $usersCallback = $this->getUsersEvolution();
                $usersChart = [
                    'labels' => array_keys($usersCallback),
                    'data' => array_values($usersCallback)
                ];

                $contentCallback = $this->getContentByType();
                $contentChart = [
                    'labels' => array_keys($contentCallback),
                    'data' => array_values($contentCallback)
                ];

            } catch (Exception $e) {
                // Fallback demo data
                $usersChart = [
                    'labels' => ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'],
                    'data' => [10, 20, 15, 30, 25, 40]
                ];
                $contentChart = [
                    'labels' => ['Articles', 'Vidéos', 'Images'],
                    'data' => [30, 20, 10]
                ];
            }

            // Derniers utilisateurs inscrits
            $derniers_utilisateurs = Utilisateurs::with(['langue', 'role'])
                ->latest()
                ->take(5)
                ->get();

            // Activités récentes
            $recentActivities = $this->getRecentActivities();

            return view('admin.dashboard.admin', compact(
                'stats', 
                'derniers_utilisateurs', 
                'usersChart', 
                'contentChart', 
                'recentActivities'
            ));

        } catch (Exception $e) {
            // En cas d'erreur, afficher le message pour le débogage
            dd($e->getMessage(), $e->getTraceAsString());
        }
    }

    private function getRecentActivities()
    {
        $activities = [];

        try {
            // Derniers inscrits
            $users = Utilisateurs::latest()->take(3)->get();
            foreach($users as $user) {
                $activities[] = [
                    'icon' => 'person-plus',
                    'color' => 'primary',
                    'title' => 'Nouvel utilisateur',
                    'time' => $user->created_at ? $user->created_at->diffForHumans() : 'Récemment',
                    'description' => "{$user->prenom} {$user->nom} a rejoint la plateforme.",
                    'user' => null
                ];
            }

            // Derniers contenus
            $contents = Contenus::with('auteur')->latest()->take(3)->get();
            foreach($contents as $content) {
                $activities[] = [
                    'icon' => 'journal-text',
                    'color' => 'success',
                    'title' => 'Nouveau contenu',
                    'time' => $content->created_at ? $content->created_at->diffForHumans() : 'Récemment',
                    'description' => "Nouveau contenu : « " . substr($content->titre, 0, 30) . "... »",
                    'user' => $content->auteur ? $content->auteur->prenom : 'Anonyme'
                ];
            }

        } catch (Exception $e) {
            // Fallback en cas d'erreur
        }

        return collect($activities)->take(5);
    }

    /* =================================================================================
        MÉTHODES POUR LES GRAPHIQUES ADMIN - AVEC GESTION D'ERREURS
    ================================================================================== */
    private function getUsersEvolution()
    {
        try {
            // Vérifier si la table utilisateurs existe
            if (!DB::getSchemaBuilder()->hasTable('utilisateurs')) {
                throw new Exception('Table utilisateurs non trouvée');
            }

            return DB::table('utilisateurs')
                ->select(DB::raw('EXTRACT(MONTH FROM date_inscription) as month, COUNT(*) as count'))
                ->whereYear('date_inscription', date('Y'))
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();

        } catch (Exception $e) {
            // Retourner des données de démo en cas d'erreur
            return [
                1 => 65, 2 => 59, 3 => 80, 4 => 81, 5 => 56,
                6 => 55, 7 => 40, 8 => 45, 9 => 60, 10 => 75, 11 => 80, 12 => 90
            ];
        }
    }

    private function getContentByType()
    {
        try {
            // Vérifier si les tables existent
            if (!DB::getSchemaBuilder()->hasTable('contenus') || !DB::getSchemaBuilder()->hasTable('type_contenus')) {
                throw new Exception('Tables de contenu non trouvées');
            }

            return DB::table('contenus')
                ->join('type_contenus', 'contenus.id_type_contenu', '=', 'type_contenus.id')
                ->select('type_contenus.nom_contenu', DB::raw('COUNT(*) as count'))
                ->groupBy('type_contenus.nom_contenu')
                ->pluck('count', 'nom_contenu')
                ->toArray();

        } catch (Exception $e) {
            return [
                'Articles' => 35,
                'Vidéos' => 25,
                'Images' => 20,
                'Audios' => 15,
                'Documents' => 5
            ];
        }
    }

    private function getRegionActivity()
    {
        try {
            if (!DB::getSchemaBuilder()->hasTable('contenus') || !DB::getSchemaBuilder()->hasTable('regions')) {
                throw new Exception('Tables régions non trouvées');
            }

            return DB::table('contenus')
                ->join('regions', 'contenus.id_region', '=', 'regions.id')
                ->select('regions.nom_region', DB::raw('COUNT(*) as count'))
                ->groupBy('regions.nom_region')
                ->orderBy('count', 'desc')
                ->limit(8)
                ->pluck('count', 'nom_region')
                ->toArray();

        } catch (Exception $e) {
            return [
                'Atlantique' => 45,
                'Borgou' => 30,
                'Zou' => 25,
                'Mono' => 20,
                'Ouémé' => 18,
                'Atacora' => 15,
                'Donga' => 12,
                'Littoral' => 35
            ];
        }
    }

    private function getCommentsActivity()
    {
        try {
            if (!DB::getSchemaBuilder()->hasTable('commentaires')) {
                throw new Exception('Table commentaires non trouvée');
            }

            return DB::table('commentaires')
                ->select(DB::raw('EXTRACT(DOW FROM created_at) as day, COUNT(*) as count'))
                ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('day')
                ->orderBy('day')
                ->pluck('count', 'day')
                ->toArray();

        } catch (Exception $e) {
            return [
                1 => 12, 2 => 19, 3 => 8, 4 => 15, 5 => 22, 6 => 18, 7 => 25
            ];
        }
    }

    private function getDemoChartData()
    {
        return [
            'users_evolution' => [
                1 => 65, 2 => 59, 3 => 80, 4 => 81, 5 => 56,
                6 => 55, 7 => 40, 8 => 45, 9 => 60, 10 => 75, 11 => 80, 12 => 90
            ],
            'content_by_type' => [
                'Articles' => 35,
                'Vidéos' => 25,
                'Images' => 20,
                'Audios' => 15,
                'Documents' => 5
            ],
            'region_activity' => [
                'Atlantique' => 45,
                'Borgou' => 30,
                'Zou' => 25,
                'Mono' => 20,
                'Ouémé' => 18,
                'Atacora' => 15,
                'Donga' => 12,
                'Littoral' => 35
            ],
            'comments_activity' => [
                1 => 12, 2 => 19, 3 => 8, 4 => 15, 5 => 22, 6 => 18, 7 => 25
            ]
        ];
    }
}
