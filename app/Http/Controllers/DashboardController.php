<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Utilisateurs;
use App\Models\Langues;
use App\Models\Roles;
use App\Models\Regions;
use App\Models\Contenus;
use App\Models\Commentaires;
use App\Models\Medias;
use App\Models\TypeContenus;
use App\Models\TypeMedias;
use Exception;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Si l'utilisateur n'a pas de rôle → lecteur
        if (!$user->id_role) {
            return $this->lecteurDashboard($user);
        }

        // Redirection selon le rôle
        switch ($user->id_role) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 3:
                return $this->moderateurDashboard();
            case 4:
            case 5:
                return $this->contributeurDashboard($user);
            default:
                return $this->lecteurDashboard($user);
        }
    }

    /* =================================================================================
        ADMIN DASHBOARD
    ================================================================================== */
    private function adminDashboard()
    {
        // Redirection should be handled by the route /admin/dashboard
        return redirect()->route('admin.dashboard');
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
        MODERATEUR DASHBOARD
    ================================================================================== */
    private function moderateurDashboard()
    {
        $stats = [
            'total_users'            => Utilisateurs::count(),
            'users_actifs'           => Utilisateurs::where('statut', 'actif')->count(),
            'total_contenus'         => Contenus::count(),
            'contenus_en_attente'    => Contenus::where('statut', 'en_attente')->count(),
            'total_commentaires'     => Commentaires::count(),
            'commentaires_signales'  => Commentaires::where('est_signalé', true)->count(),
            'total_langues'          => Langues::count(),
        ];

        $contenus_attente = Contenus::with(['auteur', 'langue'])
            ->where('statut', 'en_attente')
            ->latest()
            ->take(10)
            ->get();

        $commentaires_signales = Commentaires::with(['utilisateur', 'contenu'])
            ->where('est_signalé', true)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.moderateur', compact('stats', 'contenus_attente', 'commentaires_signales'));
    }

    /* =================================================================================
        CONTRIBUTEUR / EDITEUR DASHBOARD
    ================================================================================== */
    private function contributeurDashboard($user)
    {
        $stats = [
            'user_nom'          => $user->prenom . ' ' . $user->nom,
            'user_email'        => $user->email,
            'user_langue'       => $user->langue->nom_langue ?? 'Non définie',
            'date_inscription'  => $user->date_inscription ? $user->date_inscription->format('d/m/Y') : '—',

            // Statistiques du contributeur
            'mes_contenus'          => Contenus::where('id_auteur', $user->id)->count(),
            'contenus_publies'      => Contenus::where('id_auteur', $user->id)->where('statut', 'publié')->count(),
            'contenus_en_attente'   => Contenus::where('id_auteur', $user->id)->where('statut', 'en_attente')->count(),
            'mes_commentaires'      => Commentaires::where('id_utilisateur', $user->id)->count(),
            'mes_medias'            => Medias::where('id_utilisateur', $user->id)->count(),
        ];

        // Derniers contenus
        $derniers_contenus = Contenus::with(['langue', 'typeContenu'])
            ->where('id_auteur', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.contributeur', compact('stats', 'derniers_contenus'));
    }

    /* =================================================================================
        LECTEUR DASHBOARD
    ================================================================================== */
    private function lecteurDashboard($user)
    {
        $stats = [
            'nom_complet'      => $user->prenom . ' ' . $user->nom,
            'email'            => $user->email,
            'langue'           => $user->langue->nom_langue ?? 'Non définie',
            'date_inscription' => $user->date_inscription ? $user->date_inscription->format('d/m/Y') : '—',
            'sexe'             => $user->sexe,

            'total_contenus'   => Contenus::where('statut', 'publié')->count(),
            'total_regions'    => Regions::count(),
            'total_langues'    => Langues::count(),
            'contenus_recents' => Contenus::where('statut', 'publié')->latest()->count(),
        ];

        $contenus_recents = Contenus::with(['auteur', 'langue', 'typeContenu'])
            ->where('statut', 'publié')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard.lecteur', compact('stats', 'contenus_recents'));
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

    /* =================================================================================
        MÉTHODE DE SECOURS POUR LES DONNÉES DE DÉMO
    ================================================================================== */
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
