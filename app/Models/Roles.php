<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_role',
    ];

    public function utilisateurs()
    {
        return $this->hasMany(Utilisateurs::class, 'id_role');
    }
}
