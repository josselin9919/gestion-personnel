<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonnelTemporaire;
use App\Models\TypePersonnel;
use App\Models\Evaluation;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques générales
        $totalPersonnel = PersonnelTemporaire::count();
        $totalEvaluations = Evaluation::count();
        $scoreMoyen = Evaluation::avg('score_total') ?? 0;
        
        // Répartition par type de personnel
        $repartitionTypes = TypePersonnel::withCount('personnelsTemporaires')->get();
        
        // Personnel récemment ajouté
        $personnelRecent = PersonnelTemporaire::with('typePersonnel')
            ->latest()
            ->take(5)
            ->get();
        
        // Évaluations récentes
        $evaluationsRecentes = Evaluation::with('personnelTemporaire')
            ->latest()
            ->take(5)
            ->get();
        
        // Top personnel par score
        $topPersonnel = PersonnelTemporaire::select('personnels_temporaires.*')
            ->join('evaluations', 'personnels_temporaires.id', '=', 'evaluations.personnel_temporaire_id')
            ->selectRaw('AVG(evaluations.score_total) as score_moyen')
            ->groupBy('personnels_temporaires.id')
            ->orderByDesc('score_moyen')
            ->with('typePersonnel')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalPersonnel',
            'totalEvaluations', 
            'scoreMoyen',
            'repartitionTypes',
            'personnelRecent',
            'evaluationsRecentes',
            'topPersonnel'
        ));
    }
}
