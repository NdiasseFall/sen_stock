<?php

namespace App\Http\Controllers;

use App\Models\Inventaire;
use App\Models\Produit;
use Illuminate\Http\Request;

class InventaireController extends Controller
{
    // Liste tous les inventaires
    public function index()
    {
        return response()->json(Inventaire::all(), 200);
    }

    // Affiche un inventaire spécifique
    public function show(int $id)
    {
        $inventaire = Inventaire::findOrFail($id);
        return response()->json($inventaire, 200);
    }

    // Crée un nouvel inventaire
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produit_id' => 'required|exists:produits,id',
        ]);
        $produit = Produit::findOrFail($validated['produit_id']);
        $validated['prix_total'] = $produit->prix * $produit->quantite; // Prix total calculé

        $inventaire = Inventaire::create($validated);

        return response()->json($inventaire, 201);
    }

    // Met à jour un inventaire
    public function update(Request $request, int $id)
    {
        $inventaire = Inventaire::findOrFail($id);

        $validated = $request->validate([
            'produit_id' => 'sometimes|exists:produits,id',
            'quantite'   => 'sometimes|integer|min:1',
        ]);

        $inventaire->update($validated);

        return response()->json($inventaire, 200);
    }

    // Supprime un inventaire
    public function destroy(int $id)
    {
        $inventaire = Inventaire::findOrFail($id);
        $inventaire->delete();

        return response()->json(null, 204);
    }
}
