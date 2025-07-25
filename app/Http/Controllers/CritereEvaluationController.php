<?php

namespace App\Http\Controllers;

use App\Models\CritereEvaluation;
use App\Models\TypePersonnel;
use Illuminate\Http\Request;

class CritereEvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criteres = CritereEvaluation::with('typePersonnel')->orderBy('nom')->paginate(10);
        return view('criteres.index', compact('criteres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $typesPersonnel = TypePersonnel::all();
        return view('criteres.create', compact('typesPersonnel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_personnel_id' => 'nullable|exists:types_personnel,id',
            'poids' => 'required|numeric|min:0|max:10',
            'actif' => 'boolean',
        ]);

        CritereEvaluation::create($validated);

        return redirect()->route('criteres.index')->with('success', 'Critère d\'évaluation ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CritereEvaluation $critere)
    {
        $critere->load('typePersonnel', 'notesCriteres.evaluation.personnelTemporaire');
        return view('criteres.show', compact('critere'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CritereEvaluation $critere)
    {
        $typesPersonnel = TypePersonnel::all();
        return view('criteres.edit', compact('critere', 'typesPersonnel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CritereEvaluation $critere)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type_personnel_id' => 'nullable|exists:types_personnel,id',
            'poids' => 'required|numeric|min:0|max:10',
            'actif' => 'boolean',
        ]);

        $critere->update($validated);

        return redirect()->route('criteres.index')->with('success', 'Critère d\'évaluation mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CritereEvaluation $critere)
    {
        try {
            // Vérifier si le critère est utilisé dans des évaluations
            if ($critere->notesCriteres()->count() > 0) {
                return redirect()->back()->with('error', 'Impossible de supprimer ce critère car il est utilisé dans des évaluations.');
            }

            $critere->delete();
            return redirect()->route('criteres.index')->with('success', 'Critère d\'évaluation supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du critère: ' . $e->getMessage());
        }
    }

    /**
     * Toggle the active status of a criterion.
     */
    public function toggleActif(CritereEvaluation $critere)
    {
        $critere->update(['actif' => !$critere->actif]);

        $status = $critere->actif ? 'activé' : 'désactivé';
        return redirect()->back()->with('success', "Critère {$status} avec succès.");
    }
}
