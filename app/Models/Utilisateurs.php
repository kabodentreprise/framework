<?php
// app/Models/Utilisateur.php (Note: Nom au singulier recommandé)
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Utilisateurs extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'utilisateurs';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'sexe',
        'date_naissance',
        'date_inscription',
        'statut',
        'photo',
        'id_role',
        'id_langue',
        'email_verified_at',
        'last_login_at',
    ];

    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_inscription' => 'datetime',
        'date_naissance' => 'date',
        'last_login_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Nom de la colonne du mot de passe
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    // Relations
    public function role()
    {
        return $this->belongsTo(Roles::class, 'id_role');
    }

    public function langue()
    {
        return $this->belongsTo(Langues::class, 'id_langue');
    }

    public function contenus()
    {
        return $this->hasMany(Contenus::class, 'id_auteur');
    }

    public function contenusModeres()
    {
        return $this->hasMany(Contenus::class, 'id_moderateur');
    }

    public function commentaires()
    {
        return $this->hasMany(Commentaires::class, 'id_utilisateur');
    }

    // Accessors
    public function getNameAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function getNomCompletAttribute(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function getSexeFormateAttribute(): string
    {
        return match($this->sexe) {
            'M' => 'Homme',
            'F' => 'Femme',
            'Autre' => 'Autre',
            default => 'Non spécifié'
        };
    }

    public function getStatutFormateAttribute(): string
    {
        return match($this->statut) {
            'actif' => 'Actif',
            'inactif' => 'Inactif',
            'suspendu' => 'Suspendu',
            'restreint' => 'Accès restreint',
            'banni' => 'Banni',
            default => $this->statut
        };
    }

    public function getStatutCouleurAttribute(): string
    {
        return match($this->statut) {
            'actif' => 'success',
            'inactif' => 'secondary',
            'suspendu' => 'warning',
            'restreint' => 'info',
            'banni' => 'danger',
            default => 'light'
        };
    }

    public function getAgeAttribute(): int
    {
        return $this->date_naissance ? now()->diffInYears($this->date_naissance) : 0;
    }

    // Méthodes utilitaires
    public function estAdministrateur(): bool
    {
        return $this->id_role === 1;
    }

    public function estModerateur(): bool
    {
        return in_array($this->id_role, [1, 3]); // Admin et modérateur
    }

    public function estContributeur(): bool
    {
        return in_array($this->id_role, [1, 2, 3, 4]); // Admin, éditeur, modérateur, contributeur
    }

    public function peutSeConnecter(): bool
    {
        return in_array($this->statut, ['actif', 'restreint']);
    }

    public function estSuspendu(): bool
    {
        return $this->statut === 'suspendu';
    }

    public function estBanni(): bool
    {
        return $this->statut === 'banni';
    }

    // Méthode pour mettre à jour la dernière connexion
    public function enregistrerConnexion(): void
    {
        $this->update([
            'last_login_at' => now(),
            'statut' => $this->statut === 'inactif' ? 'actif' : $this->statut
        ]);
    }

    // Méthode pour désactiver le compte
    public function desactiver(string $raison = null): bool
    {
        return $this->update([
            'statut' => 'inactif',
            'metadata' => array_merge($this->metadata ?? [], [
                'desactivation_raison' => $raison,
                'desactivation_at' => now()->toDateTimeString(),
            ])
        ]);
    }

    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('statut', 'actif');
    }

    public function scopeInactifs($query)
    {
        return $query->where('statut', 'inactif');
    }

    public function scopeSuspendus($query)
    {
        return $query->where('statut', 'suspendu');
    }

    public function scopeBannis($query)
    {
        return $query->where('statut', 'banni');
    }

    public function scopeAvecRole($query, $roleId)
    {
        return $query->where('id_role', $roleId);
    }

    public function scopeRecents($query, $jours = 30)
    {
        return $query->where('date_inscription', '>=', now()->subDays($jours));
    }

    public function getRoleName(): string
    {
        return $this->role ? $this->role->nom_role : 'Aucun';
    }

    public function getFullName(): string
    {
        return "{$this->prenom} {$this->nom}";
    }

    public function isAdmin(): bool
    {
        return $this->id_role === 1;
    }

    public function canModerate(): bool
    {
        return $this->estModerateur();
    }

    public function canContribute(): bool
    {
        return $this->estContributeur();
    }
}
