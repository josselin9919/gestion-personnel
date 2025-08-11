<x-app-layout>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Nouveau Projet</h1>
        <a href="{{ route('projets.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('projets.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nom du projet -->
                <div>
                    <label for="nom_projet" class="block text-sm font-medium text-gray-700 mb-2">Nom du projet *</label>
                    <input type="text" name="nom_projet" id="nom_projet" value="{{ old('nom_projet') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nom_projet') border-red-500 @enderror" 
                           required>
                    @error('nom_projet')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nom du client -->
                <div>
                    <label for="nom_client" class="block text-sm font-medium text-gray-700 mb-2">Nom du client *</label>
                    <input type="text" name="nom_client" id="nom_client" value="{{ old('nom_client') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('nom_client') border-red-500 @enderror" 
                           required>
                    @error('nom_client')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de début -->
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                    <input type="date" name="date_debut" id="date_debut" value="{{ old('date_debut') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_debut') border-red-500 @enderror" 
                           required>
                    @error('date_debut')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de fin -->
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                    <input type="date" name="date_fin" id="date_fin" value="{{ old('date_fin') }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_fin') border-red-500 @enderror" 
                           required>
                    @error('date_fin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                    <select name="statut" id="statut" 
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('statut') border-red-500 @enderror" 
                            required>
                        <option value="">Sélectionner un statut</option>
                        <option value="en cours" {{ old('statut') == 'en cours' ? 'selected' : '' }}>En cours</option>
                        <option value="terminé" {{ old('statut') == 'terminé' ? 'selected' : '' }}>Terminé</option>
                        <option value="annulé" {{ old('statut') == 'annulé' ? 'selected' : '' }}>Annulé</option>
                    </select>
                    @error('statut')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror" 
                          placeholder="Description détaillée du projet...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('projets.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                    Annuler
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                    Créer le projet
                </button>
            </div>
        </form>
    </div>
</x-app-layout>

