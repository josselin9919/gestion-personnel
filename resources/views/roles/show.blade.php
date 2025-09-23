<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Détails du Rôle: " . $role->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        @can('roles.edit')
                            @if($role->name !== 'Super Admin' || auth()->user()->isSuperAdmin())
                                <a href="{{ route('roles.edit', $role->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                    Modifier
                                </a>
                            @endif
                        @endcan
                        <a href="{{ route('roles.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Retour à la liste
                        </a>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Informations du rôle -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informations générales</h3>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nom du rôle</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $role->name }}
                                    @if($role->name === 'Super Admin')
                                        <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Super Admin
                                        </span>
                                    @endif
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nombre de permissions</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $role->permissions->count() }} permission(s)</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Utilisateurs assignés</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $role->users->count() }} utilisateur(s)</p>
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Permissions assignées</h3>

                            @if($role->permissions->count() > 0)
                                @php
                                    $groupedPermissions = $role->permissions->groupBy(function ($permission) {
                                        return explode('.', $permission->name)[0];
                                    });
                                @endphp

                                <div class="space-y-4">
                                    @foreach($groupedPermissions as $module => $modulePermissions)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <h4 class="font-medium text-gray-900 mb-2 capitalize">{{ ucfirst($module) }}</h4>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($modulePermissions as $permission)
                                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                        {{ ucfirst(str_replace('.', ' ', explode('.', $permission->name)[1] ?? $permission->name)) }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Aucune permission assignée à ce rôle.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Utilisateurs assignés -->
                    @if($role->users->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Utilisateurs avec ce rôle</h3>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date d'attribution</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($role->users as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $user->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user->email }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $user->created_at->format('d/m/Y H:i') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
