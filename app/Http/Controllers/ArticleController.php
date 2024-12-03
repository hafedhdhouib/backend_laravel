<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $articles = Article::with('scategorie')->get();
            return response()->json($articles, 200);
        } catch (\Exception $e) {
            return response()->json("Sélection impossible {$e->getMessage()}");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $article = new Article([
                "designation" => $request->input("designation"),
                "marque" => $request->input("marque"),
                "reference" => $request->input("reference"),
                "qtestock" => $request->input('qtestock'),
                "prix" => $request->input("prix"),
                "imageart" => $request->input("imageart"),
                "scategorieID" => $request->input("scategorieID")
            ]);
            $article->save();
            return response()->json($article);
        } catch (\Exception $e) {
            response()->json("impossible d'inserer article {$e->getMessage()}");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($article_id)
    {
        try {
            $article = Article::findOrFail($article_id);
            return response()->json($article);
        } catch (\Exception $e) {
            return response()->json("problem de recuperation d'article {$e->getMessage()}");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $article_id)
    {
        try {
            $article = Article::findOrFail($article_id);
            $article->update($request->all());
            return response()->json($article);
        } catch (\Exception $e) {
            return response()->json("problem de modification d'article {$e->getMessage()}");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($article_id)
    {
        try {
            $article = Article::findOrFail($article_id);
            $article->delete();
            return response()->json("suppresion de l'article avec succes");
        } catch (\Exception $e) {
            return response()->json("problem lors de supprission d'article {$e->getMessage()}");
        }
    }
    public function articlesPaginate()
    {
        try {
            $perPage = request()->input('pageSize', 2);
            // Récupère la valeur dynamique pour la pagination
            $articles = Article::with('scategorie')->paginate($perPage);
            // Retourne le résultat en format JSON API
            return response()->json([
                'products' => $articles->items(), // Les articles paginés
                'totalPages' => $articles->lastPage(), // Le nombre de pages
            ]);
        } catch (\Exception $e) {
            return response()->json("Selection impossible {$e->getMessage()}");
        }
    }
    // Méthode de Pagination avec paginate
    public function paginationPaginate()
    {
        $perPage = request()->input('pageSize', 2); // Récupère la valeur dynamique pour la pagination
        // Récupère le filtre par désignation depuis la requête
        $filterDesignation = request()->input('filtre');
        // Construction de la requête
        $query = Article::with('scategories');
        // Applique le filtre sur la désignation s'il est fourni
        if ($filterDesignation) {
            $query->where('designation', 'like', '%' . $filterDesignation . '%');
        }
        // Paginer les résultats après avoir appliqué le filtre
        $articles = $query->paginate($perPage);
        // Retourne le résultat en format JSON API
        return response()->json([
            'products' => $articles->items(), // Les articles paginés
            'totalPages' => $articles->lastPage(), // Le nombre de pages
        ]);
    }
}
