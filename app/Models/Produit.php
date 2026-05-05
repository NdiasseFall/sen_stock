<?php

namespace App\Models;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    public function category()
    {
        return $this->belongsTo(Categorie::class, 'categorie_id');
    }
    protected $fillable = [
        'nom',
        'description',
        'prix',
        'quantite',
        'categorie_id'
    ];
}