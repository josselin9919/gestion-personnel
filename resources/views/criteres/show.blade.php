<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Détails du Critère d'Évaluation") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route("criteres.edit", $critere->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                            Modifier
                        </a>
                        <a href="{{ route("criteres.index") }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Retour à la liste
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations générales</h3>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nom du critère</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $critere->nom }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $critere->description ?: "Aucune description" }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Projet associé</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    @if($critere->projet)
                                        {{ $critere->projet->nom_projet }} ({{ $critere->projet->nom_client }})
                                    @else
                                        Non assigné
                                    @endif
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Poids</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $critere->poids }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Statut</label>
                                <span class="mt-1 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $critere->actif ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800" }}">
                                    {{ $critere->actif ? "Actif" : "Inactif" }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Utilisation dans les évaluations</h3>

                            @if($critere->notesCriteres->count() > 0)
                                <p class="text-sm text-gray-600 mb-4">
                                    Ce critère a été utilisé dans {{ $critere->notesCriteres->count() }} évaluation(s).
                                </p>

                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Personnel</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($critere->notesCriteres->take(5) as $note)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $note->evaluation->personnelTemporaire->nomComplet }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $note->note }}/5
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $note->evaluation->date_evaluation->format('d/m/Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @if($critere->notesCriteres->count() > 5)
                                    <p class="text-sm text-gray-500 mt-2">
                                        ... et {{ $critere->notesCriteres->count() - 5 }} autre(s) évaluation(s).
                                    </p>
                                @endif
                            @else
                                <p class="text-sm text-gray-500">Ce critère n'a pas encore été utilisé dans des évaluations.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
