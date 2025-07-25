<x-app-layout>
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Personnel -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Personnel</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPersonnel }}</p>
                </div>
            </div>
        </div>

        <!-- Total Évaluations -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Évaluations</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalEvaluations }}</p>
                </div>
            </div>
        </div>

        <!-- Score Moyen -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Score Moyen</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($scoreMoyen, 1) }}/5</p>
                </div>
            </div>
        </div>

        <!-- Nouveau Personnel -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Nouveau ce mois</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $personnelRecent->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Lists -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Répartition par Type -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par Type</h3>
            <div class="space-y-4">
                @foreach($repartitionTypes as $type)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-3 h-3 rounded-full bg-blue-500 mr-3"></div>
                        <span class="text-sm font-medium text-gray-700 capitalize">{{ str_replace('_', ' ', $type->nom) }}</span>
                    </div>
                    <span class="text-sm font-bold text-gray-900">{{ $type->personnels_temporaires_count }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $totalPersonnel > 0 ? ($type->personnels_temporaires_count / $totalPersonnel) * 100 : 0 }}%"></div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Top Personnel -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Personnel (Score)</h3>
            <div class="space-y-4">
                @forelse($topPersonnel as $personnel)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">{{ $personnel->nom }}</p>
                        <p class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $personnel->typePersonnel->nom) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-green-600">{{ number_format($personnel->score_moyen, 1) }}/5</p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Aucune évaluation disponible</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Personnel Récent -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Personnel Récent</h3>
                <a href="{{ route('personnel.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir tout</a>
            </div>
            <div class="space-y-3">
                @forelse($personnelRecent as $personnel)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <div>
                        <p class="font-medium text-gray-900">{{ $personnel->nom }}</p>
                        <p class="text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $personnel->typePersonnel->nom) }}</p>
                    </div>
                    <span class="text-xs text-gray-500">{{ $personnel->created_at->diffForHumans() }}</span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Aucun personnel ajouté récemment</p>
                @endforelse
            </div>
        </div>

        <!-- Évaluations Récentes -->
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Évaluations Récentes</h3>
                <a href="{{ route('evaluations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Voir tout</a>
            </div>
            <div class="space-y-3">
                @forelse($evaluationsRecentes as $evaluation)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <div>
                        <p class="font-medium text-gray-900">{{ $evaluation->personnelTemporaire->nom }}</p>
                        <p class="text-sm text-gray-600">{{ $evaluation->mission_contexte }}</p>
                    </div>
                    <div class="text-right">
                        <span class="font-bold text-green-600">{{ number_format($evaluation->score_total, 1) }}/5</span>
                        <p class="text-xs text-gray-500">{{ $evaluation->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Aucune évaluation récente</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions Rapides</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('personnel.create') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                    <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-blue-900">Ajouter Personnel</p>
                        <p class="text-sm text-blue-700">Nouveau membre de l'équipe</p>
                    </div>
                </a>

                <a href="{{ route('evaluations.create') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-green-900">Nouvelle Évaluation</p>
                        <p class="text-sm text-green-700">Évaluer une performance</p>
                    </div>
                </a>

                <a href="{{ route('export.excel') }}" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                    <svg class="w-8 h-8 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <p class="font-medium text-purple-900">Export Excel</p>
                        <p class="text-sm text-purple-700">Télécharger les données</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
