<div class="p-6 bg-gray-900 min-h-screen text-gray-300 font-mono text-sm">

    <div class="flex justify-between items-end mb-6">
        <div>
            <h2 class="text-2xl font-bold text-white flex items-center gap-2">
                <svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                JOURNAL D'AUDIT DE SÉCURITÉ
            </h2>
            <p class="text-xs text-gray-500 mt-1">Traçabilité des actions critiques (CIA Triad: Integrity)</p>
        </div>
        <div class="bg-gray-800 px-3 py-1 rounded border border-gray-700 text-xs">
            Total Events: {{ \App\Models\AuditLog::count() }}
        </div>
    </div>

    <div class="overflow-x-auto border border-gray-700 rounded-lg">
        <table class="min-w-full divide-y divide-gray-700">
            <thead class="bg-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Date / IP</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Acteur</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Action</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Détails</th>
                </tr>
            </thead>
            <tbody class="bg-gray-900 divide-y divide-gray-800">
                @foreach($logs as $log)
                <tr class="hover:bg-gray-800 transition">
                    <td class="px-4 py-3 whitespace-nowrap">
                        <div class="text-green-400 font-bold">{{ $log->created_at->format('d/m/Y H:i:s') }}</div>
                        <div class="text-xs text-gray-500">{{ $log->ip_address }}</div>
                    </td>
                    <!-- DANS LE TABLEAU DES LOGS -->
                    <td class="px-4 py-3 text-center"> <!-- ⬅️ Ajout de text-center ici -->
    @if($log->user)
        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-900 text-blue-200">
            {{ $log->user->name }}
        </span>
        <!-- ON AFFICHE LE RÔLE HISTORIQUE -->
        <div class="text-[10px] text-gray-500 mt-0.5 uppercase tracking-wide">
            {{ $log->user_role }}
        </div>
    @else
        <span class="text-gray-500 italic">Système</span>
    @endif
</td>
                    <td class="px-4 py-3">
                        <span class="text-white font-bold uppercase text-xs border border-gray-600 px-2 py-1 rounded">
                            {{ $log->action }}
                        </span>
                        <div class="text-xs text-white-600 mt-1">{{ $log->target }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <p class="text-gray-300 truncate max-w-xs">{{ $log->details }}</p>
                        <p class="text-[9px] text-gray-600 truncate max-w-xs" title="{{ $log->user_agent }}">
                            {{ Str::limit($log->user_agent, 40) }}
                        </p>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>
