<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Modifier l'Évaluation") }}
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

                    <form action="{{ route("evaluations.update", $evaluation->id) }}" method="POST">
                        @csrf
                        @method("PUT")

                        <div class="mb-4">
                            <label for="personnel_temporaire_id" class="block text-sm font-medium text-gray-700">Personnel à évaluer</label>
                            <select name="personnel_temporaire_id" id="personnel_temporaire_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">Sélectionner un personnel</option>
                                @foreach ($personnels as $personnel)
                                    <option value="{{ $personnel->id }}" {{ old("personnel_temporaire_id", $evaluation->personnel_temporaire_id) == $personnel->id ? "selected" : "" }}>
                                        {{ $personnel->nomComplet }}
                                    </option>
                                @endforeach
                            </select>
                            @error("personnel_temporaire_id")
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="evaluateur_nom" class="block text-sm font-medium text-gray-700">Nom de l'évaluateur</label>
                            <input type="text" name="evaluateur_nom" id="evaluateur_nom" value="{{ old("evaluateur_nom", $evaluation->evaluateur_nom) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error("evaluateur_nom")
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="date_evaluation" class="block text-sm font-medium text-gray-700">Date d'évaluation</label>
                            <input type="date" name="date_evaluation" id="date_evaluation" value="{{ old("date_evaluation", $evaluation->date_evaluation->format('Y-m-d')) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error("date_evaluation")
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="mission_contexte" class="block text-sm font-medium text-gray-700">Contexte de la mission</label>
                            <textarea name="mission_contexte" id="mission_contexte" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old("mission_contexte", $evaluation->mission_contexte) }}</textarea>
                            @error("mission_contexte")
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Critères d'évaluation</h3>
                            <div id="criteres-container">
                                <!-- Les critères seront chargés ici via JavaScript -->
                                <p class="text-gray-500">Veuillez sélectionner un personnel pour afficher les critères d'évaluation.</p>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route("evaluations.index") }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Mettre à jour l'évaluation
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const personnelSelect = document.getElementById('personnel_temporaire_id');
            const criteresContainer = document.getElementById('criteres-container');
            // S'assurer que $evaluation et notesCriteres existent avant d'appeler keyBy
            const existingNotes = @json($evaluation->notesCriteres ? $evaluation->notesCriteres->keyBy('critere_evaluation_id') : []);

            function loadCriteres(personnelId) {
                if (!personnelId) {
                    criteresContainer.innerHTML = '<p class="text-gray-500">Veuillez sélectionner un personnel pour afficher les critères d\'évaluation.</p>';
                    return;
                }

                fetch(`/api/criteres-by-personnel?personnel_id=${personnelId}`)
                    .then(response => response.json())
                    .then(data => {
                        let html = '';
                        if (data.length === 0) {
                            html = '<p class="text-gray-500">Aucun critère d\'évaluation trouvé pour ce type de personnel.</p>';
                        } else {
                            data.forEach((critere, index) => {
                                const existingNote = existingNotes[critere.id] ? existingNotes[critere.id].note : '';
                                html += `
                                    <div class="mb-4 p-4 border border-gray-200 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <h4 class="font-medium text-gray-900">${critere.nom}</h4>
                                                ${critere.description ? `<p class="text-sm text-gray-600">${critere.description}</p>` : ''}
                                                <p class="text-xs text-gray-500">Poids: ${critere.poids}</p>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <label for="notes_${critere.id}_note" class="block text-sm font-medium text-gray-700">Note (0-5)</label>
                                            <input type="hidden" name="notes[${index}][critere_id]" value="${critere.id}">
                                            <input type="number" name="notes[${index}][note]" id="notes_${critere.id}_note" min="0" max="5" step="0.1" value="${existingNote}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        </div>
                                    </div>
                                `;
                            });
                        }
                        criteresContainer.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Erreur lors du chargement des critères:', error);
                        criteresContainer.innerHTML = '<p class="text-red-500">Erreur lors du chargement des critères. Veuillez réessayer.</p>';
                    });
            }

            // Charger les critères au chargement de la page si un personnel est déjà sélectionné
            if (personnelSelect.value) {
                loadCriteres(personnelSelect.value);
            }

            personnelSelect.addEventListener('change', function() {
                loadCriteres(this.value);
            });
        });
    </script>
    @endpush
</x-app-layout>

