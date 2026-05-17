<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Illuminate\Http\Request;

class VenteController extends Controller
{
    // Liste toutes les ventes
    public function index()
    {
        return response()->json(Vente::all(), 200);
    }

    // Affiche une vente spécifique
    public function show(int $id)
    {
        $vente = Vente::findOrFail($id);
        return response()->json($vente, 200);
    }

    // Crée une nouvelle vente
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_transaction' => 'required|in:sortie,entree',
            'produit_id' => 'required|exists:produits,id',
            'quantite'   => 'required|integer|min:1',
            'prix_total' => 'required|numeric|min:0',
        ]);

        $vente = Vente::create($validated);

        return response()->json($vente, 201);
    }

    // Met à jour une vente
    public function update(Request $request, int $id)
    {
        $vente = Vente::findOrFail($id);

        $validated = $request->validate([
            'produit_id' => 'sometimes|exists:produits,id',
            'quantite'   => 'sometimes|integer|min:1',
            'prix_total' => 'sometimes|numeric|min:0',
        ]);

        $vente->update($validated);

        return response()->json($vente, 200);
    }

    // Supprime une vente
    public function destroy(int $id)
    {
        $vente = Vente::findOrFail($id);
        $vente->delete();

        return response()->json(null, 204);
    }
}
