<!-- Sidebar -->
<div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg border-r border-gray-200">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 px-4 bg-blue-600">
        <h1 class="text-xl font-bold text-white">CERD Personnel</h1>
    </div>

    <!-- Navigation -->
    <nav class="mt-8">
        <div class="px-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                </svg>
                Tableau de bord
            </a>

            <!-- Personnel -->
            <a href="{{ route('personnel.index') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('personnel.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                Personnel
            </a>

            <!-- Projets -->
            <a href="{{ route('projets.index') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('projets.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Projets
            </a>

            <!-- Évaluations -->
            <a href="{{ route('evaluations.index') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('evaluations.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                Évaluations
            </a>

            <!-- Critères -->
            <a href="{{ route('criteres.index') }}"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('criteres.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Critères d'évaluation
            </a>

            <!-- Exports -->
            <div class="pt-4 mt-4 border-t border-gray-200">
                <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Exports</p>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('export.excel') }}"
                       class="flex items-center px-4 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Excel
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- User Info -->
    <div class="absolute bottom-0 w-full p-4 border-t border-gray-200">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                    <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-gray-500 hover:text-gray-700">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

