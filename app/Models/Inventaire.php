<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    protected $fillable = [
        'prix_total',
        'produit_id',
    ];
}
