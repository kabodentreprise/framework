<?php
// app/Http/Controllers/AchatController.php
namespace App\Http\Controllers;

use App\Models\Achats;
use App\Models\Contenus;
use App\Services\FedaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AchatsController extends Controller
{
    protected $fedaPayService;

    public function __construct(FedaPayService $fedaPayService)
    {
        $this->middleware('auth')->except(['webhook']);
        $this->fedaPayService = $fedaPayService;
    }

    /**
     * Afficher l'historique des achats de l'utilisateur
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Achat::with(['contenu', 'contenu.auteur', 'contenu.region', 'contenu.langue'])
            ->deUtilisateur($user->id)
            ->orderBy('created_at', 'desc');

        // Filtrage
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('search')) {
            $query->whereHas('contenu', function($q) use ($request) {
                $q->where('titre', 'like', '%' . $request->search . '%');
            });
        }

        $achats = $query->paginate(15);

        return view('achats.index', compact('achats'));
    }

    /**
     * Afficher les détails d'un achat
     */
    public function show($id)
    {
        $achat = Achat::with(['contenu', 'utilisateur'])
            ->findOrFail($id);

        // Vérifier que l'utilisateur peut voir cet achat
        if ($achat->id_utilisateur !== Auth::id() && !Auth::user()->estAdministrateur()) {
            abort(403, 'Accès non autorisé');
        }

        return view('achats.show', compact('achat'));
    }

    /**
     * Initier un achat (créer la transaction FedaPay)
     */
    public function initierAchat(Request $request, $contenuId)
    {
        $user = Auth::user();
        $contenu = Contenu::publie()->payant()->findOrFail($contenuId);

        // Vérifications
        if ($contenu->estGratuit()) {
            return back()->with('error', 'Ce contenu est gratuit, aucun achat nécessaire.');
        }

        if ($contenu->estAchetePar($user->id)) {
            return back()->with('info', 'Vous avez déjà acheté ce contenu.');
        }

        if ($contenu->id_auteur === $user->id) {
            return back()->with('info', 'Vous êtes l\'auteur de ce contenu, vous y avez accès gratuitement.');
        }

        // Créer l'achat en attente
        $achat = Achat::create([
            'id_utilisateur' => $user->id,
            'id_contenu' => $contenu->id,
            'reference' => Achat::genererReference(),
            'montant' => $contenu->prix,
            'montant_auteur' => $contenu->calculerMontantAuteur(),
            'montant_plateforme' => $contenu->calculerMontantPlateforme(),
            'statut' => 'en_attente',
            'metadata' => [
                'user_ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'contenu_titre' => $contenu->titre,
                'contenu_slug' => $contenu->slug,
            ],
        ]);

        try {
            // Créer la transaction FedaPay
            $transactionData = [
                'amount' => $contenu->prix,
                'currency' => 'XOF',
                'description' => "Achat: {$contenu->titre}",
                'callback_url' => route('achats.callback', $achat->id),
                'customer' => [
                    'email' => $user->email,
                    'firstname' => $user->prenom,
                    'lastname' => $user->nom,
                ],
                'metadata' => [
                    'achat_id' => $achat->id,
                    'contenu_id' => $contenu->id,
                    'user_id' => $user->id,
                ],
            ];

            $result = $this->fedaPayService->createTransaction($transactionData);

            if ($result['success']) {
                // Mettre à jour l'achat avec l'ID de transaction FedaPay
                $achat->update([
                    'feda_transaction_id' => $result['transaction']['id'],
                    'metadata' => array_merge($achat->metadata ?? [], [
                        'feda_transaction' => $result['transaction'],
                    ]),
                ]);

                // Rediriger vers FedaPay
                return redirect($result['redirect_url']);
            } else {
                $achat->marquerCommeEchoue($result['error']);
                return back()->with('error', 'Erreur lors de la création de la transaction: ' . $result['error']);
            }

        } catch (\Exception $e) {
            $achat->marquerCommeEchoue($e->getMessage());
            return back()->with('error', 'Erreur: ' . $e->getMessage());
        }
    }

    /**
     * Callback après paiement (retour de FedaPay)
     */
    public function callback(Request $request, $achatId)
    {
        $achat = Achat::findOrFail($achatId);

        // Vérifier que c'est bien l'utilisateur concerné
        if ($achat->id_utilisateur !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        // Vérifier le statut avec FedaPay
        if ($achat->feda_transaction_id) {
            $transaction = $this->fedaPayService->getTransaction($achat->feda_transaction_id);

            if ($transaction && $transaction['status'] === 'approved') {
                $achat->marquerCommePaye([
                    'feda_status' => $transaction['status'],
                    'feda_callback_data' => $request->all(),
                ]);

                // Rediriger vers la page de succès
                return redirect()->route('achats.success', $achat->id)
                    ->with('success', 'Paiement effectué avec succès !');
            }
        }

        // Si échec, rediriger vers la page d'échec
        return redirect()->route('achats.failure', $achat->id)
            ->with('error', 'Le paiement a échoué. Veuillez réessayer.');
    }

    /**
     * Page de succès après paiement
     */
    public function success($achatId)
    {
        $achat = Achat::with(['contenu'])->findOrFail($achatId);

        if ($achat->id_utilisateur !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        if (!$achat->estPaye()) {
            return redirect()->route('achats.show', $achat->id)
                ->with('warning', 'Paiement non confirmé.');
        }

        return view('achats.success', compact('achat'));
    }

    /**
     * Page d'échec de paiement
     */
    public function failure($achatId)
    {
        $achat = Achat::with(['contenu'])->findOrFail($achatId);

        if ($achat->id_utilisateur !== Auth::id()) {
            abort(403, 'Accès non autorisé');
        }

        return view('achats.failure', compact('achat'));
    }

    /**
     * Webhook FedaPay (pour les notifications asynchrones)
     */
    public function webhook(Request $request)
    {
        // Vérifier la signature
        $payload = $request->getContent();
        $signature = $request->header('X-FedaPay-Signature');

        if (!$this->fedaPayService->verifyWebhookSignature($payload, $signature)) {
            return response()->json(['error' => 'Signature invalide'], 401);
        }

        $data = json_decode($payload, true);

        // Traiter l'événement
        switch ($data['event']) {
            case 'transaction.approved':
                $this->traiterTransactionApprouvee($data['data']);
                break;

            case 'transaction.declined':
                $this->traiterTransactionRefusee($data['data']);
                break;

            case 'transaction.canceled':
                $this->traiterTransactionAnnulee($data['data']);
                break;
        }

        return response()->json(['status' => 'ok']);
    }

    /**
     * Traiter une transaction approuvée
     */
    private function traiterTransactionApprouvee(array $transaction)
    {
        $achat = Achat::where('feda_transaction_id', $transaction['id'])->first();

        if ($achat && $achat->estEnAttente()) {
            $achat->marquerCommePaye([
                'feda_webhook_data' => $transaction,
                'webhook_received_at' => now()->toDateTimeString(),
            ]);

            // Envoyer une notification à l'utilisateur
            // event(new AchatPaye($achat));
        }
    }

    /**
     * Traiter une transaction refusée
     */
    private function traiterTransactionRefusee(array $transaction)
    {
        $achat = Achat::where('feda_transaction_id', $transaction['id'])->first();

        if ($achat && $achat->estEnAttente()) {
            $achat->marquerCommeEchoue('Transaction refusée par FedaPay');
        }
    }

    /**
     * Traiter une transaction annulée
     */
    private function traiterTransactionAnnulee(array $transaction)
    {
        $achat = Achat::where('feda_transaction_id', $transaction['id'])->first();

        if ($achat && $achat->estEnAttente()) {
            $achat->marquerCommeEchoue('Transaction annulée');
        }
    }

    /**
     * API pour vérifier si un contenu est acheté
     */
    public function verifierAchat($contenuId)
    {
        $user = Auth::user();
        $contenu = Contenu::findOrFail($contenuId);

        $estAchete = $contenu->estAchetePar($user->id);
        $peutVoirComplet = $contenu->peutVoirComplet($user->id);

        return response()->json([
            'est_achete' => $estAchete,
            'peut_voir_complet' => $peutVoirComplet,
            'contenu' => [
                'id' => $contenu->id,
                'titre' => $contenu->titre,
                'type_acces' => $contenu->type_acces,
                'prix' => $contenu->prix,
            ],
        ]);
    }

    /**
     * Générer une facture PDF
     */
    public function facture($achatId)
    {
        $achat = Achat::with(['contenu', 'utilisateur'])->findOrFail($achatId);

        if ($achat->id_utilisateur !== Auth::id() && !Auth::user()->estAdministrateur()) {
            abort(403, 'Accès non autorisé');
        }

        if (!$achat->estPaye()) {
            return back()->with('error', 'Impossible de générer une facture pour un achat non payé.');
        }

        $pdf = \PDF::loadView('achats.facture', compact('achat'));

        return $pdf->download("facture-{$achat->reference}.pdf");
    }
}
