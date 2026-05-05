<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class vente extends Model
{
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    protected $fillable = [
        'type_transaction',
        'quantite',
        'produit_id',
        'prix_total',
    ];
}
