<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Détails de l'Utilisateur: " . $user->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        @can("users.edit")
                            @if(!$user->isSuperAdmin() || auth()->user()->isSuperAdmin())
                                <a href="{{ route("users.edit", $user->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Modifier
                                </a>
                            @endif
                        @endcan
                        <a href="{{ route("users.index") }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Retour à la liste
                        </a>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Informations de l'utilisateur -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations générales</h3>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $user->name }}
                                    @if($user->isSuperAdmin())
                                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Super Admin
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Adresse email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Date de création</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Dernière mise à jour</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Rôles et Permissions -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Rôles et Permissions</h3>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Rôles assignés</label>
                                @if($user->roles->count() > 0)
                                    <div class="flex flex-wrap gap-2 mt-1">
                                        @foreach($user->roles as $role)
                                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                {{ $role->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-1 text-sm text-gray-500">Aucun rôle assigné.</p>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Permissions effectives</label>
                                @if($user->getAllPermissions()->count() > 0)
                                    @php
                                        $groupedPermissions = $user->getAllPermissions()->groupBy(function ($permission) {
                                            return explode('.', $permission->name)[0];
                                        });
                                    @endphp

                                    <div class="space-y-4 mt-1">
                                        @foreach($groupedPermissions as $module => $modulePermissions)
                                            <div class="border border-gray-200 rounded-lg p-4">
                                                <h4 class="font-medium text-gray-900 mb-2 capitalize">{{ ucfirst($module) }}</h4>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach($modulePermissions as $permission)
                                                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                            {{ ucfirst(str_replace('.', ' ', explode('.', $permission->name)[1] ?? $permission->name)) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="mt-1 text-sm text-gray-500">Aucune permission effective.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
