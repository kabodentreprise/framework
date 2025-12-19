<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contenus;
use App\Models\Achats;
use Illuminate\Support\Str;

class PaiementController extends Controller
{
    public function initier(Request $request)
    {
        // Cette méthode n'est plus utilisée directement par le formulaire "Code Front"
        // mais peut servir d'API ou de fallback.
        return redirect()->route('catalogue.index');
    }

    /**
     * Traite le retour du widget FedaPay (Checkout)
     */
    public function callback(Request $request)
    {
        // 1. Validation des entrées
        $request->validate([
            'id_contenu' => 'required|exists:contenus,id',
            // Le widget FedaPay envoie 'id' comme ID de transaction (ou parfois 'transaction_id' selon version, 
            // avec checkout.js c'est souvent posté dans le form si on le configure, 
            // mais par défaut checkout.js envoie des champs hidden: 
            // 'fedapay_transaction_id' ou 'id' selon le mode.
            // On va assumer que le script ajoute 'id' ou on le cherche dans le request.
        ]);

        $transactionId = $request->input('id'); // ID de la transaction FedaPay envoyé par le widget

        if (!$transactionId) {
             return redirect()->route('catalogue.show', ['slug' => Contenus::find($request->id_contenu)->slug])
                ->with('error', 'Identifiant de transaction manquant.');
        }

        $user = Auth::user();
        $contenu = Contenus::findOrFail($request->id_contenu);

        // 2. Vérifier si déjà traité (Idempotency)
        $achatExistant = Achats::where('feda_transaction_id', $transactionId)->first();
        if ($achatExistant) {
            return redirect()->route('bibliotheque.index')
                ->with('info', 'Cet achat a déjà été validé.');
        }

        try {
            // 3. Configuration FedaPay SERVER-SIDE
            \FedaPay\FedaPay::setApiKey(config('fedapay.secret_key'));
            \FedaPay\FedaPay::setEnvironment(config('fedapay.environment'));

            // 4. Récupérer et Vérifier la transaction depuis FedaPay
            $transaction = \FedaPay\Transaction::retrieve($transactionId);

            // Vérifications de sécurité
            if ($transaction->status !== 'approved') {
                throw new \Exception("Le paiement n'a pas été approuvé (Status: " . $transaction->status . ")");
            }

            // Vérifier le montant (attention aux décimales/types)
            if (intval($transaction->amount) < intval($contenu->prix)) {
                 // Potentielle fraude ou erreur montant
                 throw new \Exception("Montant payé incorrect.");
            }

            // 5. Enregistrement de l'achat
            $reference = 'ACHAT-' . $user->id . '-' . $contenu->id . '-' . time();

            $achat = new Achats();
            $achat->id_utilisateur = $user->id;
            $achat->id_contenu = $contenu->id;
            $achat->reference = $reference; // Notre référence interne
            $achat->feda_transaction_id = $transaction->id; // ID FedaPay
            $achat->montant = $transaction->amount;
            $achat->montant_auteur = $contenu->calculerMontantAuteur();
            $achat->montant_plateforme = $contenu->calculerMontantPlateforme();
            $achat->statut = 'payé';
            $achat->mode_paiement = 'fedapay';
            $achat->date_paiement = now();
            $achat->date_achat = now(); // Pour garder la cohérence
            $achat->save();

            // Incrémenter les stats
            $contenu->increment('achats_count');
            $contenu->increment('revenu_total', $achat->montant);

            // CRÉDITER LE SOLDE DE L'AUTEUR
            if ($contenu->auteur) {
                // On utilise increment pour être thread-safe sur le solde
                $contenu->auteur->increment('solde', $achat->montant_auteur);
            }

            return redirect()->route('bibliotheque.index')
                ->with('success', 'Paiement validé avec succès !');

        } catch (\Exception $e) {
            // Log l'erreur pour débogage
            // Log::error('Erreur Paiement FedaPay: ' . $e->getMessage());

            return redirect()->route('catalogue.show', $contenu->slug)
                ->with('error', 'Erreur lors de la validation du paiement : ' . $e->getMessage());
        }
    }
}
