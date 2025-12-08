<?php
// app/Models/Contenu.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contenus extends Model
{
    use SoftDeletes;

    protected $table = 'contenus';
    protected $primaryKey = 'id';

    protected $fillable = [
        'titre',
        'texte',
        'excerpt',
        'slug',
        'statut',
        'date_creation',
        'date_validation',
        'published_at',
        'id_type_contenu',
        'id_auteur',
        'id_moderateur',
        'id_region',
        'id_langue',
        'parent_id',
        'version',
        // Champs payants
        'type_acces',
        'prix',
        'pourcentage_auteur',
        'extrait_gratuit',
        'vues_count',
        'achats_count',
        'revenu_total',
        'mots_cles',
        'metadata',
    ];

    protected $casts = [
        'date_creation' => 'datetime',
        'date_validation' => 'datetime',
        'published_at' => 'datetime',
        'type_acces' => 'string',
        'prix' => 'decimal:2',
        'pourcentage_auteur' => 'decimal:2',
        'vues_count' => 'integer',
        'achats_count' => 'integer',
        'revenu_total' => 'decimal:2',
        'mots_cles' => 'array',
        'metadata' => 'array',
        'version' => 'integer',
    ];

    // ===== RELATIONS =====
    public function auteur()
    {
        return $this->belongsTo(Utilisateurs::class, 'id_auteur');
    }

    public function moderateur()
    {
        return $this->belongsTo(Utilisateurs::class, 'id_moderateur');
    }

    public function region()
    {
        return $this->belongsTo(Regions::class, 'id_region');
    }

    public function langue()
    {
        return $this->belongsTo(Langues::class, 'id_langue');
    }

    public function typeContenu()
    {
        return $this->belongsTo(TypeContenus::class, 'id_type_contenu');
    }

    public function parent()
    {
        return $this->belongsTo(Contenus::class, 'parent_id');
    }

    public function traductions()
    {
        return $this->hasMany(Contenus::class, 'parent_id');
    }

    public function medias()
    {
        return $this->hasMany(Medias::class, 'id_contenu');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaires::class, 'id_contenu');
    }

    public function achats()
    {
        return $this->hasMany(Achats::class, 'id_contenu');
    }

    // ...



    // ===== MÉTHODES POUR CONTENUS PAYANTS =====

    /**
     * Vérifie si le contenu est gratuit
     */
    public function estGratuit(): bool
    {
        return $this->type_acces === 'gratuit';
    }

    /**
     * Vérifie si le contenu est payant
     */
    public function estPayant(): bool
    {
        return $this->type_acces === 'payant';
    }

    /**
     * Vérifie si un utilisateur a acheté ce contenu
     */
    public function estAchetePar(int $utilisateurId): bool
    {
        return $this->achats()
            ->where('id_utilisateur', $utilisateurId)
            ->where('statut', 'payé')
            ->exists();
    }

    /**
     * Vérifie si un utilisateur peut voir le contenu complet
     */
    public function peutVoirComplet(int $utilisateurId = null): bool
    {
        // Si gratuit, toujours visible
        if ($this->estGratuit()) {
            return true;
        }

        // Si payant, vérifier l'achat
        if ($utilisateurId && $this->estAchetePar($utilisateurId)) {
            return true;
        }

        return false;
    }

    /**
     * Obtenir le texte à afficher selon l'accès
     */
    public function getTexteAAfficher(int $utilisateurId = null): string
    {
        if ($this->peutVoirComplet($utilisateurId)) {
            return $this->texte;
        }

        // Si payant et non acheté, retourner l'extrait gratuit
        return $this->extrait_gratuit ?: $this->genererExtraitGratuit();
    }

    /**
     * Générer un extrait gratuit automatiquement
     */
    private function genererExtraitGratuit(): string
    {
        $texte = strip_tags($this->texte);

        if (strlen($texte) <= 500) {
            return $texte;
        }

        $extrait = substr($texte, 0, 500);
        $dernierEspace = strrpos($extrait, ' ');

        return $dernierEspace !== false
            ? substr($extrait, 0, $dernierEspace) . '...'
            : $extrait . '...';
    }

    /**
     * Calculer le montant pour l'auteur
     */
    public function calculerMontantAuteur(): float
    {
        if ($this->estGratuit() || !$this->prix) {
            return 0;
        }

        return $this->prix * ($this->pourcentage_auteur / 100);
    }

    /**
     * Calculer le montant pour la plateforme
     */
    public function calculerMontantPlateforme(): float
    {
        if ($this->estGratuit() || !$this->prix) {
            return 0;
        }

        return $this->prix * ((100 - $this->pourcentage_auteur) / 100);
    }

    /**
     * Enregistrer un achat
     */
    public function enregistrerAchat(int $utilisateurId, array $data): Achats
    {
        $achat = Achats::create([
            'id_utilisateur' => $utilisateurId,
            'id_contenu' => $this->id,
            'reference' => $data['reference'],
            'feda_transaction_id' => $data['feda_transaction_id'] ?? null,
            'montant' => $this->prix,
            'montant_auteur' => $this->calculerMontantAuteur(),
            'montant_plateforme' => $this->calculerMontantPlateforme(),
            'statut' => 'payé',
            'metadata' => $data['metadata'] ?? [],
        ]);

        // Mettre à jour les statistiques
        $this->increment('achats_count');
        $this->increment('revenu_total', $this->prix);

        return $achat;
    }

    // ===== SCOPES =====

    /**
     * Scope pour les contenus gratuits
     */
    public function scopeGratuit($query)
    {
        return $query->where('type_acces', 'gratuit');
    }

    /**
     * Scope pour les contenus payants
     */
    public function scopePayant($query)
    {
        return $query->where('type_acces', 'payant');
    }

    /**
     * Scope pour les contenus accessibles par un utilisateur
     */
    public function scopeAccessiblePar($query, int $utilisateurId = null)
    {
        return $query->where(function($q) use ($utilisateurId) {
            // Contenus gratuits
            $q->where('type_acces', 'gratuit');

            // Ou contenus payants achetés par l'utilisateur
            if ($utilisateurId) {
                $q->orWhereHas('achats', function($query) use ($utilisateurId) {
                    $query->where('id_utilisateur', $utilisateurId)
                          ->where('statut', 'payé');
                });
            }
        });
    }

    /**
     * Scope pour les contenus publiés
     */
    public function scopePublie($query)
    {
        return $query->where('statut', 'publié')
                     ->whereNotNull('published_at');
    }

    /**
     * Scope pour les contenus en attente
     */
    public function scopeEnAttente($query)
    {
        return $query->where('statut', 'en_attente');
    }

    /**
     * Scope pour les contenus d'un auteur
     */
    public function scopeDeLauteur($query, int $auteurId)
    {
        return $query->where('id_auteur', $auteurId);
    }

    /**
     * Scope pour les contenus publiés (alias pluriel)
     */
    public function scopePublies($query)
    {
        return $this->scopePublie($query);
    }

    /**
     * Scope pour les brouillons
     */
    public function scopeBrouillons($query)
    {
        return $query->where('statut', 'brouillon');
    }

    /**
     * Scope pour les contenus rejetés
     */
    public function scopeRejetes($query)
    {
        return $query->where('statut', 'rejeté');
    }
}
