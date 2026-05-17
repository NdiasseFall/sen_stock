<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaire extends Model
{
    use HasFactory;
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'produit_id');
    }

    protected $fillable = [
        'produit_id',
        'prix_total',
    ];
}
