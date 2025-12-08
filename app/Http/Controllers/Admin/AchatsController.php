<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achats;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AchatsController extends Controller
{
    /**
     * Affiche la liste des paiements.
     */
    public function index()
    {
        return view('admin.payment.index');
    }

    /**
     * API pour DataTables.
     */
    public function api(Request $request)
    {
        $query = Achats::with(['utilisateur', 'contenu'])->select('achats.*');

        return DataTables::of($query)
            ->editColumn('id_utilisateur', function ($item) {
                return $item->utilisateur ? $item->utilisateur->getFullName() : 'Utilisateur inconnu';
            })
            ->editColumn('id_contenu', function ($item) {
                return $item->contenu ? $item->contenu->titre : 'Contenu supprimé';
            })
            ->editColumn('montant', function ($item) {
                return number_format($item->montant, 0, ',', ' ') . ' FCFA';
            })
            ->editColumn('date_achat', function ($item) {
                return $item->date_achat ? $item->date_achat->format('d/m/Y H:i') : '-';
            })
            ->editColumn('statut', function ($item) {
                $colors = [
                    'payé' => 'bg-green-100 text-green-800',
                    'en_attente' => 'bg-yellow-100 text-yellow-800',
                    'échoué' => 'bg-red-100 text-red-800',
                    'remboursé' => 'bg-gray-100 text-gray-800',
                ];
                $color = $colors[$item->statut] ?? 'bg-gray-100 text-gray-800';
                return '<span class="px-2 py-1 text-xs font-semibold rounded-full ' . $color . '">' . ucfirst($item->statut) . '</span>';
            })
            ->addColumn('actions', function ($item) {
                return '<a href="' . route('admin.paiements.show', $item->id) . '" class="text-blue-600 hover:text-blue-900 font-bold">Voir</a>';
            })
            ->rawColumns(['statut', 'actions'])
            ->make(true);
    }

    /**
     * Affiche les détails d'un paiement.
     */
    public function show($id)
    {
        $achat = Achats::with(['utilisateur', 'contenu'])->findOrFail($id);
        return view('admin.payment.show', compact('achat'));
    }
}
