<div class="p-6 bg-white border-b border-gray-200">

    <!-- Header avec Stats -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Utilisateurs & Clients</h2>
        <div class="bg-blue-50 text-blue-800 px-4 py-2 rounded-lg font-bold border border-blue-200">
            <!-- On compte tout le monde sauf les admins -->
            Total Clients Inscrits : {{ \App\Models\User::where('role', '!=', 'admin')->count() }}
        </div>
    </div>

    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Utilisateur</th>
                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rôle & Type</th>
                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact</th>
                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Inscription</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50 transition">
                    <td class="py-3 px-4 text-gray-500 font-mono text-xs">#{{ $user->id }}</td>

                    <td class="py-3 px-4">
                        <div class="flex items-center">
                            <!-- Avatar Initiale -->
                            <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center text-white font-bold text-sm
                                {{ $user->role === 'admin' ? 'bg-red-600' : 'bg-blue-600' }}">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="py-3 px-4">
                        @if($user->role === 'admin')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                Administrateur
                            </span>
                        @else
                            @if($user->client_type === 'entreprise')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    Entreprise
                                </span>
                            @elseif($user->client_type === 'touriste')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Touriste
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Particulier
                                </span>
                            @endif
                        @endif
                    </td>

                    <td class="py-3 px-4 text-sm text-gray-600">
                        {{ $user->phone ?? '-' }}<br>
                        <span class="text-xs text-gray-400">{{ $user->city }}</span>
                    </td>

                    <td class="py-3 px-4 text-sm text-gray-600">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
