<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medias extends Model
{
    use HasFactory;

    protected $table = 'medias'; // ← Ajoutez cette ligne

    protected $fillable = [
        'chemin',
        'description',
        'id_contenu',
        'id_type_media',
    ];

    public function contenu()
    {
        return $this->belongsTo(Contenus::class, 'id_contenu');
    }

    public function typeMedia()
    {
        return $this->belongsTo(TypeMedias::class, 'id_type_media');
    }
}
