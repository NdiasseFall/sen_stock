<?php

namespace App\Http\Controllers;

use App\Models\Produit as ProduitModel;
use App\Models\Inventaire as InventaireModel;
use Illuminate\Http\Request;

class Produit extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits = ProduitModel::all();
        if ($produits->isNotEmpty()) {
            return response()->json($produits);
        } else {
            return response()->json(['message' => 'Aucun produit trouvé'], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'quantite' => 'required|integer',
            'categorie_id' => 'required |exists:categories,id'
        ]);
        $produit = ProduitModel::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'quantite' => $request->quantite,
            'categorie_id' => $request->categorie_id
        ]);
        $inventaire = InventaireModel::create([
            'prix_total' => $request->prix * $request->quantite,
            'produit_id' => $produit->id
        ]);
        return response()->json($produit, 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produit = ProduitModel::find($id);
        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }
        return response()->json($produit);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $produit = ProduitModel::find($id);
        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }
        $request->validate([
            'nom' => 'required|string',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'quantite' => 'required|integer',
            'categorie_id' => 'required|exists:categories,id'
        ]);

        $produit->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'prix' => $request->prix,
            'quantite' => $request->quantite,
            'categorie_id' => $request->categorie_id
        ]);


        $inventaire = InventaireModel::where('produit_id', $produit->id)->first();
        if (!$inventaire) {
            return response()->json(['message' => 'Inventaire introuvable'], 404);
        }
        $inventaire->update([
            'prix_total' => $request->prix * $request->quantite,
            'produit_id' => $produit->id
        ]);

        // $produit->save();
        return response()->json($produit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produit = ProduitModel::find($id);
        if (!$produit) {
            return response()->json(['message' => 'Produit non trouvé'], 404);
        }
        $produit->delete();
        return response()->json([
            'message' => 'Produit supprimé',
            'produit' => $produit
        ]);
    }
}
