<?php

namespace App\Http\Controllers;

use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    // Liste tous les produits
    public function index()
    {
        return response()->json(Produit::all(), 200);
    }

    // Affiche un produit spécifique
    public function show(int $id)
    {
        $produit = Produit::findOrFail($id);
        return response()->json($produit, 200);
    }

    // Crée un nouveau produit
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'          => 'required|string|max:255',
            'prix'         => 'required|numeric|min:0',
            'quantite'     => 'required|integer|min:1',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $produit = Produit::create($validated);

        return response()->json($produit, 201);
    }

    // Met à jour un produit
    public function update(Request $request, int $id)
    {
        $produit = Produit::findOrFail($id);

        $validated = $request->validate([
            'nom'          => 'sometimes|string|max:255',
            'description'  => 'sometimes|text',
            'prix'         => 'sometimes|numeric|min:0',
            'quantite'     => 'sometimes|integer|min:1',
            'categorie_id' => 'sometimes|exists:categories,id',
        ]);

        $produit->update($validated);

        return response()->json($produit, 200);
    }

    // Supprime un produit
    public function destroy(int $id)
    {
        $produit = Produit::findOrFail($id);
        $produit->delete();

        return response()->json(null, 204);
    }
}
