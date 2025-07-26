<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $categories = Categorie::all();
        } catch (\Exception $e) {
            return redirect()->route('categories')->with('error', 'Une erreur est survenue lors de la récupération des catégories.');
        }
        
        return view('parametres.categories.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
            ], [
                'name.required' => 'Le nom de la catégorie est requis.',
                'name.string' => 'Le nom de la catégorie doit être une chaîne de caractères.',
                'name.max' => 'Le nom de la catégorie ne peut pas dépasser 255 caractères.',
            ]);

            Categorie::create($request->all());

            return redirect()->route('categories')->with('success', 'Catégorie créée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('categories')->with('error', 'Une erreur est survenue lors de la création de la catégorie.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorie $categorie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorie $categorie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $categorie)
    {
        try{
            $request->validate([
                'name' => 'required|string|max:255',
            ], [
                'name.required' => 'Le nom de la catégorie est requis.',
                'name.string' => 'Le nom de la catégorie doit être une chaîne de caractères.',
                'name.max' => 'Le nom de la catégorie ne peut pas dépasser 255 caractères.',
            ]);

            $categorie->update(['name' => $request->name]);

            return redirect()->route('categories')->with('success', 'Catégorie mise à jour avec succès');
        } catch (\Exception $e) {
            return redirect()->route('categories')->with('error', 'Une erreur est survenue lors de la modification de la catégorie.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $categorie)
    {
        try{
            $categorie->delete();

            return redirect()->route('categories')->with('success', 'Catégorie supprimée avec succès');
        } catch (\Exception $e) {
            return redirect()->route('categories')->with('error', 'Une erreur est survenue lors de la suppression de la catégorie.');
        }
    }
}
