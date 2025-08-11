<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de l'évaluation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Évaluation du personnel: {{ $evaluation->personnelTemporaire->nomComplet }}</h3>
                        <a href="{{ route("evaluations.index") }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Retour à la liste
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm font-medium text-gray-700">Projet:</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $evaluation->projet->nom_projet ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Client du projet:</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $evaluation->projet->nom_client ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Évaluateur:</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $evaluation->evaluateur_nom }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Date d'évaluation:</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $evaluation->date_evaluation->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-700">Score Total:</p>
                            <p class="mt-1 text-sm text-gray-900">
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
                            </p>
                        </div>
                    </div>

                    @if($evaluation->commentaire_global)
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-700">Commentaire Global:</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $evaluation->commentaire_global }}</p>
                        </div>
                    @endif

                    <h4 class="text-md font-medium text-gray-900 mb-4">Notes par critère:</h4>
                    @if($evaluation->notesCriteres->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Critère</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note (0-5)</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poids</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($evaluation->notesCriteres as $noteCritere)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $noteCritere->critereEvaluation->nom }}</div>
                                                @if($noteCritere->critereEvaluation->description)
                                                    <div class="text-sm text-gray-500">{{ $noteCritere->critereEvaluation->description }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($noteCritere->note, 1) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $noteCritere->critereEvaluation->poids }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500">Aucune note par critère pour cette évaluation.</p>
                    @endif

                    <div class="mt-6 flex justify-end">
                        <a href="{{ route("evaluations.edit", $evaluation->id) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Modifier l'évaluation
                        </a>
                        <form action="{{ route("evaluations.destroy", $evaluation->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')">
                                Supprimer l'évaluation
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
