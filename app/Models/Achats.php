<?php
// app/Models/Achat.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Achats extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'achats';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_utilisateur',
        'id_contenu',
        'reference',
        'feda_transaction_id',
        'montant',
        'montant_auteur',
        'montant_plateforme',
        'statut',
        'date_achat',
        'date_remboursement',
        'metadata',
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'montant_auteur' => 'decimal:2',
        'montant_plateforme' => 'decimal:2',
        'metadata' => 'array',
        'date_achat' => 'datetime',
        'date_remboursement' => 'datetime',
    ];

    protected $attributes = [
        'statut' => 'en_attente',
    ];

    // ===== RELATIONS =====
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }

    public function contenu()
    {
        return $this->belongsTo(Contenu::class, 'id_contenu');
    }

    // ===== MÉTHODES UTILITAIRES =====

    /**
     * Vérifie si l'achat est payé
     */
    public function estPaye(): bool
    {
        return $this->statut === 'payé';
    }

    /**
     * Vérifie si l'achat est en attente
     */
    public function estEnAttente(): bool
    {
        return $this->statut === 'en_attente';
    }

    /**
     * Vérifie si l'achat est échoué
     */
    public function estEchoue(): bool
    {
        return $this->statut === 'échoué';
    }

    /**
     * Vérifie si l'achat est remboursé
     */
    public function estRembourse(): bool
    {
        return $this->statut === 'remboursé';
    }

    /**
     * Vérifie si l'achat peut être remboursé
     */
    public function peutEtreRembourse(): bool
    {
        return $this->estPaye() &&
               !$this->estRembourse() &&
               $this->date_achat > now()->subDays(30);
    }

    /**
     * Marquer comme payé
     */
    public function marquerCommePaye(array $data = []): self
    {
        $this->update([
            'statut' => 'payé',
            'date_achat' => now(),
            'metadata' => array_merge($this->metadata ?? [], $data),
        ]);

        return $this;
    }

    /**
     * Marquer comme échoué
     */
    public function marquerCommeEchoue(string $raison = null): self
    {
        $this->update([
            'statut' => 'échoué',
            'metadata' => array_merge($this->metadata ?? [], [
                'raison_echec' => $raison,
                'date_echec' => now()->toDateTimeString(),
            ]),
        ]);

        return $this;
    }

    /**
     * Rembourser l'achat
     */
    public function rembourser(string $referenceRemboursement = null): self
    {
        $this->update([
            'statut' => 'remboursé',
            'date_remboursement' => now(),
            'metadata' => array_merge($this->metadata ?? [], [
                'reference_remboursement' => $referenceRemboursement,
                'date_remboursement' => now()->toDateTimeString(),
            ]),
        ]);

        return $this;
    }

    /**
     * Générer une référence unique
     */
    public static function genererReference(): string
    {
        do {
            $reference = 'ACH-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(6));
        } while (self::where('reference', $reference)->exists());

        return $reference;
    }

    // ===== SCOPES =====

    /**
     * Scope pour les achats payés
     */
    public function scopePayes($query)
    {
        return $query->where('statut', 'payé');
    }

    /**
     * Scope pour les achats en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope pour les achats d'un utilisateur
     */
    public function scopeDeUtilisateur($query, int $utilisateurId)
    {
        return $query->where('id_utilisateur', $utilisateurId);
    }

    /**
     * Scope pour les achats d'un contenu
     */
    public function scopeDeContenu($query, int $contenuId)
    {
        return $query->where('id_contenu', $contenuId);
    }

    /**
     * Scope pour les achats récents
     */
    public function scopeRecents($query, int $jours = 30)
    {
        return $query->where('date_achat', '>=', now()->subDays($jours));
    }
}
