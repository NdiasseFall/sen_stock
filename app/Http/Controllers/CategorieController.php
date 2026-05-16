<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorie as CategorieModel;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(CategorieModel::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);
        if (CategorieModel::where('nom', $request->nom)->exists()) {
            return response()->json(['message' => 'Catégorie déjà existante'], 400);
        }
        $categorie = CategorieModel::create([
            'nom' => $request->nom,
        ]);
        return response()->json($categorie, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function filterByCategorie(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:categories,id',

        ]);

        if (!CategorieModel::where('id', $request->id)->exists()) {
            return response()->json(['message' => "Catégorie avec l'id $request->id non trouvée"], 404);
        }
        $categorie = CategorieModel::with('produits')->find($request->id);

        if ($categorie->produits->isEmpty()) {
            return response()->json(['message' => 'Produits vide'], 404);
        }

        return response()->json($categorie->produits);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $categorie = CategorieModel::findOrFail($id);
        return response()->json($categorie, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $categorie = CategorieModel::find($id);
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }
        return response()->json($categorie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $categorie = CategorieModel::find($id);
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);
        $categorie->update([
            'nom' => $request->nom,
        ]);
        return response()->json($categorie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categorie = CategorieModel::find($id);
        if (!$categorie) {
            return response()->json(['message' => 'Catégorie non trouvée'], 404);
        }
        $categorie->delete();
        return response()->json(['message' => 'Catégorie supprimée'], 204);
    }
}
