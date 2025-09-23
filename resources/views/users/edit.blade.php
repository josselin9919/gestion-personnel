<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Modifier l'Utilisateur: " . $user->name) }}
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

                    <form action="{{ route("users.update", $user->id) }}" method="POST">
                        @csrf
                        @method("PUT")

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Informations personnelles</h3>

                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nom complet *</label>
                                    <input type="text" name="name" id="name" value="{{ old("name", $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error("name")
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse email *</label>
                                    <input type="email" name="email" id="email" value="{{ old("email", $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error("email")
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                                    <input type="password" name="password" id="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error("password")
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Attribution des rôles</h3>

                                @if($user->isSuperAdmin() && !auth()->user()->isSuperAdmin())
                                    <p class="text-sm text-red-600 mb-4">Vous ne pouvez pas modifier les rôles d'un Super Admin.</p>
                                @else
                                    <div class="space-y-3">
                                        @foreach($roles as $role)
                                            <div class="flex items-center">
                                                <input type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->id }}"
                                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                                       {{ in_array($role->name, old("roles", $userRoles)) ? "checked" : "" }}>
                                                <label for="role_{{ $role->id }}" class="ml-2 block text-sm text-gray-900">
                                                    {{ $role->name }}
                                                    @if($role->name === "Super Admin")
                                                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                            Accès complet
                                                        </span>
                                                    @endif
                                                </label>
                                            </div>
                                            @if($role->permissions->count() > 0)
                                                <div class="ml-6 text-xs text-gray-500">
                                                    {{ $role->permissions->count() }} permission(s) incluse(s)
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    @error("roles")
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror

                                    <div class="mt-4 p-3 bg-blue-50 rounded-md">
                                        <p class="text-sm text-blue-700">
                                            <strong>Note:</strong> Vous pouvez assigner plusieurs rôles à un utilisateur. Les permissions seront cumulées.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route("users.index") }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Annuler
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Mettre à jour l'utilisateur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
