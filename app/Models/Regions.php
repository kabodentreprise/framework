<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    use HasFactory;

    protected $table = 'regions'; // ← Ajoutez cette ligne

    protected $fillable = [
        'nom_region',
        'description',
        'population',
        'superficie',
        'localisation',
    ];

    public function contenus()
    {
        return $this->hasMany(Contenus::class, 'id_region');
    }

    public function langues()
    {
        return $this->belongsToMany(Langues::class, 'parlers', 'id_region', 'id_langue');
    }
}
