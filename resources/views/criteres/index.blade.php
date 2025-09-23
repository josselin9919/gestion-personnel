<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Critères d'Évaluation") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route("criteres.create") }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Ajouter un Critère
                        </a>
                    </div>

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
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projet</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poids</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($criteres as $critere)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $critere->nom }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($critere->description, 50) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $critere->projet ? $critere->projet->nom_projet : "Non assigné" }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $critere->poids }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $critere->actif ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800" }}">
                                                {{ $critere->actif ? "Actif" : "Inactif" }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route("criteres.show", $critere->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Voir</a>
                                            <a href="{{ route("criteres.edit", $critere->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Modifier</a>
                                            <form action="{{ route("criteres.toggle-actif", $critere->id) }}" method="POST" class="inline-block mr-2">
                                                @csrf
                                                @method("PATCH")
                                                <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                                    {{ $critere->actif ? "Désactiver" : "Activer" }}
                                                </button>
                                            </form>
                                            <form action="{{ route("criteres.destroy", $critere->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method("DELETE")
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce critère ?')">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Aucun critère trouvé.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $criteres->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
