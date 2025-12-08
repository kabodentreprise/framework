<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parlers extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_region',
        'id_langue',
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'id_region');
    }

    public function langue()
    {
        return $this->belongsTo(Langue::class, 'id_langue');
    }
}
