<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projets = Projet::orderBy('date_debut', 'desc')->paginate(10);
        return view('projets.index', compact('projets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_projet' => 'required|string|max:255',
            'nom_client' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'description' => 'nullable|string',
            'statut' => 'required|in:en cours,terminé,annulé'
        ]);

        Projet::create($request->all());

        return redirect()->route('projets.index')
            ->with('success', 'Projet créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Projet $projet)
    {
        $projet->load('evaluations.personnelTemporaire');
        return view('projets.show', compact('projet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Projet $projet)
    {
        return view('projets.edit', compact('projet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Projet $projet)
    {
        $request->validate([
            'nom_projet' => 'required|string|max:255',
            'nom_client' => 'required|string|max:255',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'description' => 'nullable|string',
            'statut' => 'required|in:en cours,terminé,annulé'
        ]);

        $projet->update($request->all());

        return redirect()->route('projets.index')
            ->with('success', 'Projet mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Projet $projet)
    {
        $projet->delete();

        return redirect()->route('projets.index')
            ->with('success', 'Projet supprimé avec succès.');
    }
}
