<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Liste des Évaluations") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Filtres d'évaluation</h3>
                        <a href="{{ route("evaluations.create") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ajouter une Évaluation
                        </a>
                    </div>

                    <form action="{{ route("evaluations.index") }}" method="GET" class="mb-6 p-4 border rounded-lg shadow-sm bg-gray-50">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="projet_id" class="block text-sm font-medium text-gray-700">Projet</label>
                                <select name="projet_id" id="projet_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Tous les projets</option>
                                    @foreach ($projets as $projet)
                                        <option value="{{ $projet->id }}" {{ request("projet_id") == $projet->id ? "selected" : "" }}>
                                            {{ $projet->nom_projet }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="type_personnel_id" class="block text-sm font-medium text-gray-700">Type de personnel</label>
                                <select name="type_personnel_id" id="type_personnel_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Tous les types</option>
                                    @foreach ($typesPersonnel as $type)
                                        <option value="{{ $type->id }}" {{ request("type_personnel_id") == $type->id ? "selected" : "" }}>
                                            {{ $type->nom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="personnel_id" class="block text-sm font-medium text-gray-700">Personnel spécifique</label>
                                <select name="personnel_id" id="personnel_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Tout le personnel</option>
                                    @foreach ($personnels as $personnel)
                                        <option value="{{ $personnel->id }}" {{ request("personnel_id") == $personnel->id ? "selected" : "" }}>
                                            {{ $personnel->nomComplet }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="score_min" class="block text-sm font-medium text-gray-700">Score Min</label>
                                <input type="number" name="score_min" id="score_min" step="0.1" min="0" max="5" value="{{ request("score_min") }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="score_max" class="block text-sm font-medium text-gray-700">Score Max</label>
                                <input type="number" name="score_max" id="score_max" step="0.1" min="0" max="5" value="{{ request("score_max") }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="date_debut" class="block text-sm font-medium text-gray-700">Date Début</label>
                                <input type="date" name="date_debut" id="date_debut" value="{{ request("date_debut") }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="date_fin" class="block text-sm font-medium text-gray-700">Date Fin</label>
                                <input type="date" name="date_fin" id="date_fin" value="{{ request("date_fin") }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div>
                                <label for="evaluateur_nom" class="block text-sm font-medium text-gray-700">Nom Évaluateur</label>
                                <input type="text" name="evaluateur_nom" id="evaluateur_nom" value="{{ request("evaluateur_nom") }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div class="flex justify-end mt-4 space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Appliquer les filtres
                            </button>
                            <a href="{{ route("evaluations.index") }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Réinitialiser
                            </a>
                        </div>
                    </form>

                    @if (session("success"))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session("success") }}</span>
                        </div>
                    @endif

                    @if (session("error"))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session("error") }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Personnel</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Évaluateur</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'évaluation</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Score Total</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($evaluations as $evaluation)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $evaluation->personnelTemporaire->nomComplet }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $evaluation->projet->nom_projet ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $evaluation->evaluateur_nom }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $evaluation->date_evaluation->format("d/m/Y") }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ number_format($evaluation->score_total, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route("evaluations.show", $evaluation->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Voir</a>
                                            <a href="{{ route("evaluations.edit", $evaluation->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Modifier</a>
                                            <form action="{{ route("evaluations.destroy", $evaluation->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Aucune évaluation trouvée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $evaluations->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

