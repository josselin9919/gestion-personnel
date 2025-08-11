<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">{{ $projet->nom_projet }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('projets.edit', $projet) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Modifier
            </a>
            <a href="{{ route('projets.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour
            </a>
        </div>
    </div>

    <!-- Informations du projet -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informations du projet</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Client</label>
                <p class="mt-1 text-sm text-gray-900">{{ $projet->nom_client }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Statut</label>
                @php
                    $statusColors = [
                        'en cours' => 'bg-blue-100 text-blue-800',
                        'terminé' => 'bg-green-100 text-green-800',
                        'annulé' => 'bg-red-100 text-red-800'
                    ];
                @endphp
                <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$projet->statut] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($projet->statut) }}
                </span>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Date de début</label>
                <p class="mt-1 text-sm text-gray-900">{{ $projet->date_debut->format('d/m/Y') }}</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">Date de fin</label>
                <p class="mt-1 text-sm text-gray-900">{{ $projet->date_fin->format('d/m/Y') }}</p>
            </div>
        </div>
        
        @if($projet->description)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <p class="mt-1 text-sm text-gray-900">{{ $projet->description }}</p>
            </div>
        @endif
    </div>

    <!-- Évaluations liées au projet -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-900">Évaluations du projet</h2>
            <a href="{{ route('evaluations.create', ['projet_id' => $projet->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nouvelle évaluation
            </a>
        </div>

        @if($projet->evaluations->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Personnel</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Évaluateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($projet->evaluations as $evaluation)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $evaluation->personnelTemporaire->prenom }} {{ $evaluation->personnelTemporaire->nom }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $evaluation->personnelTemporaire->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $evaluation->evaluateur_nom }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $evaluation->date_evaluation->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($evaluation->score_total)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($evaluation->score_total >= 4) bg-green-100 text-green-800
                                            @elseif($evaluation->score_total >= 3) bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800
                                            @endif">
                                            {{ number_format($evaluation->score_total, 2) }}/5
                                        </span>
                                    @else
                                        <span class="text-gray-500">Non calculé</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('evaluations.show', $evaluation) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                        Voir
                                    </a>
                                    <a href="{{ route('evaluations.edit', $evaluation) }}" class="text-indigo-600 hover:text-indigo-900">
                                        Modifier
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune évaluation</h3>
                <p class="mt-1 text-sm text-gray-500">Commencez par créer une évaluation pour ce projet.</p>
                <div class="mt-6">
                    <a href="{{ route('evaluations.create', ['projet_id' => $projet->id]) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Nouvelle évaluation
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>

