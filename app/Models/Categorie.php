<?php

namespace App\Models;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    public function produits()
    {
        return $this->hasMany(Produit::class, 'categorie_id');
    }
    protected $fillable = [
        'nom'
    ];
}