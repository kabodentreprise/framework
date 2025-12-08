<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Langues extends Model
{
    use HasFactory;

    protected $table = 'langues'; // ← Ajoutez cette ligne

    protected $fillable = [
        'nom_langue',
        'code_langue',
        'description',
    ];

    public function utilisateurs()
    {
        return $this->hasMany(Utilisateurs::class, 'id_langue');
    }

    public function contenus()
    {
        return $this->hasMany(Contenus::class, 'id_langue');
    }

    public function regions()
    {
        return $this->belongsToMany(Regions::class, 'parlers', 'id_langue', 'id_region');
    }
}
