<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vente as VenteModel;
use App\Models\Inventaire as InventaireModel;
use App\Models\Produit;
use Ramsey\Uuid\Type\Decimal;

class vente extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventes = VenteModel::with('produit')->get();
        return response()->json($ventes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'type_transaction' => 'required|string|in:entre,sortie',
            'quantite' => 'required|integer',
            'produit_id' => 'required|integer|exists:produits,id',
        ]);

        $produit = Produit::find($request->produit_id);
        if (!$produit) {
            return response()->json(['error' => 'Produit non trouvé'], 404);
        }
        $inventaire = InventaireModel::where('produit_id', $produit->id)->first();
        if (!$inventaire) {
            return response()->json(['message' => 'Inventaire introuvable'], 404);
        }

        if ($request->type_transaction === 'sortie' && $produit->quantite < $request->quantite) {
            return response()->json(['error' => 'Quantité insuffisante en stock'], 400);
        }

        $vente = VenteModel::create([
            'type_transaction' => $request->type_transaction,
            'quantite' => $request->quantite,
            'produit_id' => $request->produit_id,
            'prix_total' => new Decimal($produit->prix * $request->quantite),
        ]);
        if ($request->type_transaction === 'sortie') {
            $produit->quantite -= $request->quantite;

            $inventaire->update([
                'prix_total' => $produit->prix * $produit->quantite,
                'produit_id' => $produit->id
            ]);
        } else {
            $produit->quantite += $request->quantite;
            $inventaire->update([
                'prix_total' => $produit->prix * $produit->quantite,
                'produit_id' => $produit->id
            ]);
        }
        $produit->save();

        return response()->json($vente, 201);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {}
}
