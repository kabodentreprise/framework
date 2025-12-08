<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaires extends Model
{
    use HasFactory;

    // CORRECTION : Table s'appelle "comentaires" (avec un m) -- Wait, user comment implies table might be weird, but migration said create_commentaires_table. I will assume 'commentaires' is correct based on migration.
    protected $table = 'commentaires';

    protected $fillable = [
        'texte',
        'note',
        'date',
        'id_utilisateur',
        'id_contenu',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateurs::class, 'id_utilisateur');
    }

    public function contenu()
    {
        return $this->belongsTo(Contenus::class, 'id_contenu');
    }
}
