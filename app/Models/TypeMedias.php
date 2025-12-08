<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeMedias extends Model
{
    use HasFactory;

    protected $table = 'type_medias';

    protected $fillable = [
        'nom_media',
    ];

    public function medias()
    {
        return $this->hasMany(Medias::class, 'id_type_media');
    }
}
