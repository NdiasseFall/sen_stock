<?php

namespace App\Http\Controllers;

use App\Models\Inventaire as InventaireModel;

class Inventaire extends Controller
{
    public function index()
    {
        $inventaires = InventaireModel::with('produit')->get();
        if ($inventaires->isNotEmpty()) {
            return response()->json($inventaires);
        } else {
            return response()->json(['message' => 'Aucun inventaire trouvé'], 404);
        }
    }
}
