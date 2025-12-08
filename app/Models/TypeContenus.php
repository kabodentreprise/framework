<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeContenus extends Model
{
    use HasFactory;

    protected $table = 'type_contenus'; // ← Adaptez au nom réel de votre table

    protected $fillable = [
        'nom_contenu',
    ];

    public function contenus()
    {
        return $this->hasMany(Contenus::class, 'id_type_contenu');
    }
}
