<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\PersonnelTemporaire;
use App\Models\CritereEvaluation;
use App\Models\NoteCritere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evaluations = Evaluation::with(
            [
                'personnelTemporaire',
                'notesCriteres.critereEvaluation'
            ]
        )->orderBy('date_evaluation', 'desc')->paginate(10);
        return view('evaluations.index', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $personnels = PersonnelTemporaire::all();
        // Les critères seront chargés dynamiquement via AJAX en fonction du personnel sélectionné
        return view('evaluations.create', compact('personnels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'personnel_temporaire_id' => 'required|exists:personnels_temporaires,id',
            'evaluateur_nom' => 'required|string|max:255',
            'mission_contexte' => 'nullable|string',
            'date_evaluation' => 'required|date',
            'notes' => 'required|array',
            'notes.*.critere_id' => 'required|exists:criteres_evaluation,id',
            'notes.*.note' => 'required|numeric|min:0|max:5',
        ]);

        DB::beginTransaction();
        try {
            $evaluation = Evaluation::create([
                'personnel_temporaire_id' => $validated['personnel_temporaire_id'],
                'evaluateur_nom' => $validated['evaluateur_nom'],
                'mission_contexte' => $validated['mission_contexte'],
                'date_evaluation' => $validated['date_evaluation'],
            ]);

            foreach ($validated['notes'] as $noteData) {
                NoteCritere::create([
                    'evaluation_id' => $evaluation->id,
                    'critere_evaluation_id' => $noteData['critere_id'],
                    'note' => $noteData['note'],
                ]);
            }

            $evaluation->calculerScoreTotal();

            DB::commit();
            return redirect()->route('evaluations.index')->with('success', 'Évaluation ajoutée avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Erreur lors de l\'ajout de l\'évaluation: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        $evaluation->load('personnelTemporaire', 'notesCriteres.critereEvaluation');
        return view('evaluations.show', compact('evaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        $personnels = PersonnelTemporaire::all();
        // Les critères seront chargés dynamiquement via AJAX en fonction du personnel sélectionné
        $evaluation->load('notesCriteres');
        return view('evaluations.edit', compact('evaluation', 'personnels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $validated = $request->validate([
            'personnel_temporaire_id' => 'required|exists:personnels_temporaires,id',
            'evaluateur_nom' => 'required|string|max:255',
            'mission_contexte' => 'nullable|string',
            'date_evaluation' => 'required|date',
            'notes' => 'required|array',
            'notes.*.critere_id' => 'required|exists:criteres_evaluation,id',
            'notes.*.note' => 'required|numeric|min:0|max:5',
        ]);

        DB::beginTransaction();
        try {
            $evaluation->update([
                'personnel_temporaire_id' => $validated['personnel_temporaire_id'],
                'evaluateur_nom' => $validated['evaluateur_nom'],
                'mission_contexte' => $validated['mission_contexte'],
                'date_evaluation' => $validated['date_evaluation'],
            ]);

            $evaluation->notesCriteres()->delete();
            foreach ($validated['notes'] as $noteData) {
                NoteCritere::create([
                    'evaluation_id' => $evaluation->id,
                    'critere_evaluation_id' => $noteData['critere_id'],
                    'note' => $noteData['note'],
                ]);
            }

            $evaluation->calculerScoreTotal();

            DB::commit();
            return redirect()->route('evaluations.index')->with('success', 'Évaluation mise à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour de l\'évaluation: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        DB::beginTransaction();
        try {
            $evaluation->notesCriteres()->delete();
            $evaluation->delete();
            DB::commit();
            return redirect()->route('evaluations.index')->with('success', 'Évaluation supprimée avec succès.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erreur lors de la suppression de l\'évaluation: ' . $e->getMessage());
        }
    }

    /**
     * Display the evaluation history for a specific personnel.
     */
    public function historique(PersonnelTemporaire $personnel)
    {
        $evaluations = $personnel->evaluations()->with('notesCriteres.critereEvaluation')->orderBy('date_evaluation', 'desc')->paginate(10);
        return view('personnel.historique_evaluations', compact('personnel', 'evaluations'));
    }

    /**
     * Get evaluation criteria based on personnel type.
     */
    public function getCriteresByPersonnel(Request $request)
    {
        $personnelId = $request->input('personnel_id');
        $personnel = PersonnelTemporaire::with('typePersonnel')->find($personnelId);

        if (!$personnel) {
            return response()->json([], 404);
        }

        $criteres = CritereEvaluation::where('actif', true)
            ->where(function ($query) use ($personnel) {
                $query->whereNull('type_personnel_id') // Critères généraux
                      ->orWhere('type_personnel_id', $personnel->type_personnel_id); // Critères spécifiques au type de personnel
            })
            ->get();

        return response()->json($criteres);
    }
}

