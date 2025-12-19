<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Achats;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Exception;

class ContributorSubscriptionController extends Controller
{
    /**
     * Affiche la page d'abonnement / upgrade
     */
    public function index()
    {
        $user = Auth::user();
        
        // Vérifier si déjà abonné
        $hasSubscription = Achats::where('id_utilisateur', $user->id)
            ->where('type', 'abonnement')
            ->where('statut', 'payé')
            ->exists();

        if ($hasSubscription) {
            return redirect()->route('dashboard')->with('info', 'Vous avez déjà un abonnement contributeur actif.');
        }

        return view('contributeur.abonnement', compact('user'));
    }

    /**
     * Initier le paiement FedaPay pour l'abonnement
     */
    public function initier(Request $request)
    {
        $user = Auth::user();
        $montant = 5000; // 5000 FCFA

        try {
            FedaPay::setApiKey(config('fedapay.secret_key'));
            FedaPay::setEnvironment(config('fedapay.environment'));

            $transaction = Transaction::create([
                'description' => 'Abonnement Contributeur - ' . $user->prenom . ' ' . $user->nom,
                'amount' => $montant,
                'currency' => ['iso' => 'XOF'],
                'callback_url' => route('contributeur.paiement.callback'),
                'customer' => [
                    'firstname' => $user->prenom,
                    'lastname' => $user->nom,
                    'email' => $user->email,
                ],
            ]);

            $token = $transaction->generateToken();

            return redirect($token->url);

        } catch (Exception $e) {
            return back()->with('error', 'Erreur lors de l\'initialisation du paiement : ' . $e->getMessage());
        }
    }

    /**
     * Callback après paiement
     */
    public function callback(Request $request)
    {
        $transactionId = $request->input('id');
        $status = $request->input('status'); // FedaPay envoie parfois le statut directement

        if (!$transactionId) {
            return redirect()->route('contributeur.abonnement')->with('error', 'ID de transaction manquant.');
        }

        try {
            FedaPay::setApiKey(config('fedapay.secret_key'));
            FedaPay::setEnvironment(config('fedapay.environment'));

            $transaction = Transaction::retrieve($transactionId);

            if ($transaction->status == 'approved') {
                $user = Auth::user();

                // Vérifier doublon
                $exist = Achats::where('feda_transaction_id', $transaction->id)->exists();
                if ($exist) {
                    return redirect()->route('dashboard')->with('info', 'Paiement déjà validé.');
                }

                // Enregistrer l'achat d'abonnement
                Achats::create([
                    'id_utilisateur' => $user->id,
                    'id_contenu' => null, // Pas de contenu lié
                    'type' => 'abonnement',
                    'reference' => 'ABO-' . $user->id . '-' . time(),
                    'feda_transaction_id' => $transaction->id,
                    'montant' => $transaction->amount,
                    'montant_auteur' => 0, // Tout pour la plateforme
                    'montant_plateforme' => $transaction->amount,
                    'statut' => 'payé',
                    'date_achat' => now(),
                    'metadata' => [
                        'description' => 'Abonnement Contributeur à vie',
                        'mode' => 'fedapay'
                    ]
                ]);

                // Mettre à jour le rôle de l'utilisateur s'il n'est pas déjà admin/modérateur
                // On suppose que s'il paie, il devient Contributeur (ID 3) s'il était simple Utilisateur (ID 4)
                if ($user->id_role == 4) { // Utilisateur simple
                    $user->id_role = 3; // Contributeur
                    $user->save();
                }

                return redirect()->route('dashboard')->with('success', 'Félicitations ! Vous êtes maintenant Contributeur. Vous pouvez créer des contenus.');
            } else {
                return redirect()->route('contributeur.abonnement')->with('error', 'Le paiement n\'a pas été approuvé.');
            }

        } catch (Exception $e) {
            return redirect()->route('contributeur.abonnement')->with('error', 'Erreur lors de la vérification : ' . $e->getMessage());
        }
    }
}
