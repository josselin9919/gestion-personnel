<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Modifier le Critère d'Évaluation") }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session("error"))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session("error") }}</span>
                        </div>
                    @endif

                    <form action="{{ route("criteres.update", $critere->id) }}" method="POST">
                        @csrf
                        @method("PUT")

                        <div class="mb-4">
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom du critère</label>
                            <input type="text" name="nom" id="nom" value="{{ old("nom", $critere->nom) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error("nom")
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old("description", $critere->description) }}</textarea>
                            @error("description")
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="projet_id" class="block text-sm font-medium text-gray-700">Projet *</label>
                            <select name="projet_id" id="projet_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Sélectionner un projet</option>
                                @foreach ($projets as $projet)
                                    <option value="{{ $projet->id }}" {{ old("projet_id", $critere->projet_id) == $projet->id ? "selected" : "" }}>
                                        {{ $projet->nom_projet }} ({{ $projet->nom_client }})
                                    </option>
                                @endforeach
                            </select>
                            @error("projet_id")
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="poids" class="block text-sm font-medium text-gray-700">Poids (0-10)</label>
                            <input type="number" name="poids" id="poids" min="0" max="10" step="0.1" value="{{ old("poids", $critere->poids) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error("poids")
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="actif" id="actif" value="1" {{ old("actif", $critere->actif) ? "checked" : "" }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="actif" class="ml-2 block text-sm text-gray-900">Critère actif</label>
                            </div>
                            @error("actif")
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route("criteres.index") }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Mettre à jour le critère
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
