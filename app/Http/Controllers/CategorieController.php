<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $categories = Categorie::all();
            return response()->json($categories);
        } catch (\Exception $e) {
            return response()->json("probleme de récupération de la liste des catégories");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $article = new Article([
                "designation" => $request->input('designation'),
                "marque" => $request->input('marque'),
                "reference" => $request->input('reference'),
                "qtestock" => $request->input('qtestock'),
                "prix" => $request->input('prix'),
                "imageart" => $request->input('imageart'),
                "scategorieID" => $request->input('scategorieID'),
            ]);
            $article->save();
            return response()->json($article);
        } catch (\Exception $e) {
            return response()->json("insertion impossible {$e->getMessage()}");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $categorie = Categorie::findOrFail($id);
            return response()->json($categorie);
        } catch (\Exception $e) {
            return response()->json("probleme de récupération des données");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        try {
            $categorie = Categorie::findorFail($id);
            $categorie->update($request->all());
            return response()->json($categorie);
        } catch (\Exception $e) {
            return response()->json("probleme de modification");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $categorie = Categorie::findOrFail($id);
            $categorie->delete();
            return response()->json("catégorie supprimée avec succes");
        } catch (\Exception $e) {
            return response()->json("probleme de suppression de catégorie");
        }
    }
}
