<div class="space-y-8">

    <!-- EN-TÊTE & FILTRES -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Performance & Statistiques</h2>
            <p class="text-sm text-gray-500">Analysez l'activité en temps réel.</p>
        </div>

        <!-- SELECTEUR PÉRIODE -->
        <div class="relative">
            <select wire:model.live="period" class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 pl-4 pr-10 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 font-bold text-sm cursor-pointer">
                <option value="today">Aujourd'hui</option>
                <option value="week">Cette Semaine</option>
                <option value="month">Ce Mois-ci</option>
                <option value="year">Cette Année</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    <!-- 1. KPI CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Chiffre d'Affaires -->
        <div class="bg-gray-900 text-white p-6 rounded-2xl shadow-lg relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-4 opacity-10 transform translate-x-2 -translate-y-2 group-hover:scale-110 transition">
                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="text-gray-400 text-xs uppercase tracking-widest mb-1">Revenus ({{ ucfirst($period) }})</div>
            <div class="text-2xl font-black text-blue-400">{{ number_format($revenue, 0, ',', ' ') }} <span class="text-sm text-gray-500">FCFA</span></div>
        </div>

        <!-- Réservations -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-orange-500">
            <div class="text-gray-500 text-xs uppercase tracking-widest mb-1">Réservations</div>
            <div class="text-3xl font-bold text-gray-800">{{ $bookingsCount }}</div>
        </div>

        <!-- Nouveaux Clients -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500">
            <div class="text-gray-500 text-xs uppercase tracking-widest mb-1">Nouveaux Clients</div>
            <div class="text-3xl font-bold text-gray-800">{{ $clientsCount }}</div>
        </div>

        <!-- Flotte -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-blue-500">
            <div class="text-gray-500 text-xs uppercase tracking-widest mb-1">Parc Auto</div>
            <div class="text-3xl font-bold text-gray-800">{{ $vehiclesCount }}</div>
        </div>
    </div>

    <!-- 2. SECTION GRAPHIQUES (Ligne + Camembert) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- A. COURBE (2/3 largeur) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex flex-col">
            <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                Évolution Financière & Volume
            </h3>
            <div class="relative w-full h-72" wire:ignore>
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- B. CAMEMBERT (1/3 largeur) -->
        <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex flex-col items-center justify-center">
            <h3 class="font-bold text-gray-800 mb-6 w-full flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                Répartition Clients ({{ ucfirst($period) }})
            </h3>
            <div class="relative w-full h-64" wire:ignore>
                <canvas id="clientPieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- 3. TOP VÉHICULES (Horizontal en bas) -->
    <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            Top Performances ({{ ucfirst($period) }})
        </h3>

        <!-- Grille Horizontale -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($topVehicles as $index => $stat)
                @if($stat->vehicle)
                <div class="group flex items-center gap-4 p-4 bg-gray-50 hover:bg-blue-50 border border-gray-200 hover:border-blue-200 rounded-xl transition duration-300 shadow-sm hover:shadow-md transform hover:-translate-y-1">

                    <!-- Rang -->
                    <div class="text-2xl font-black text-gray-300 w-8">#{{ $index + 1 }}</div>

                    <!-- Image avec Zoom -->
                    <div class="w-16 h-16 rounded-lg overflow-hidden border border-white shadow-md relative shrink-0">
                        @if($stat->vehicle->image)
                            <img src="{{ asset('storage/'.$stat->vehicle->image) }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-500">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 text-xs">No Img</div>
                        @endif
                    </div>

                    <!-- Infos -->
                    <div class="flex-grow min-w-0">
                        <h4 class="font-bold text-gray-900 text-sm truncate group-hover:text-blue-700">{{ $stat->vehicle->brand }} {{ $stat->vehicle->name }}</h4>
                        <span class="text-[10px] uppercase font-bold text-gray-500 bg-white px-2 py-0.5 rounded shadow-sm">{{ $stat->vehicle->type }}</span>
                    </div>

                    <!-- Score -->
                    <div class="text-right pl-2 border-l border-gray-200">
                        <span class="block font-black text-2xl text-blue-600 leading-none">{{ $stat->total }}</span>
                        <span class="text-[9px] text-gray-400 uppercase font-bold tracking-wider">Loc.</span>
                    </div>
                </div>
                @endif
            @empty
                <div class="col-span-3 text-center text-gray-400 py-4 italic text-sm bg-gray-50 rounded-lg">Aucune location sur cette période.</div>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {

            // --- 1. INITIALISATION LIGNE (Revenue) ---
            const ctxLine = document.getElementById('revenueChart').getContext('2d');
            let revenueChart = new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [
                        {
                            label: 'Chiffre d\'Affaires (FCFA)',
                            data: @json($chartRevenue),
                            borderColor: '#2563eb', // Bleu
                            backgroundColor: 'rgba(37, 99, 235, 0.1)',
                            borderWidth: 3, tension: 0.4, fill: true, yAxisID: 'y'
                        },
                        {
                            label: 'Coûts Maintenance (FCFA)', // NOUVELLE COURBE
                            data: @json($chartMaintenance),
                            borderColor: '#ef4444', // Rouge
                            backgroundColor: 'rgba(239, 68, 68, 0.1)', // Rouge transparent
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true,
                            yAxisID: 'y', // Même axe que le revenu (Argent)
                            order: 1 // Devant le bleu
                        },
                        {
                            label: 'Réservations',
                            data: @json($chartBookings),
                            borderColor: '#f97316', // Orange
                            backgroundColor: 'transparent',
                            borderWidth: 2, borderDash: [5, 5], tension: 0.4, yAxisID: 'y1'
                        }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                   scales: {
    y: {
        type: 'linear',
        display: true,
        position: 'left',
        beginAtZero: true
    },
    y1: {
        type: 'linear',
        display: true,
        position: 'right',
        beginAtZero: true,
        grid: { drawOnChartArea: false },

        // AJOUT : Force les nombres entiers (0, 1, 2, 3...)
        ticks: {
            stepSize: 1,
            precision: 0
        },
        // Optionnel : Pour ne pas que la courbe touche le plafond si max = 1
        suggestedMax: 5
    }
}
                }
            });

            // --- 2. INITIALISATION CAMEMBERT (Clients) ---
            const ctxPie = document.getElementById('clientPieChart').getContext('2d');
            let clientPieChart = new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: @json($pieLabels),
                    datasets: [{
                        data: @json($pieData),
                        backgroundColor: ['#3b82f6', '#8b5cf6', '#f59e0b'], // Bleu, Violet, Orange
                        borderWidth: 0, hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom' } }
                }
            });

            // --- 3. MISE À JOUR LIVEWIRE ---
            Livewire.on('update-charts', (data) => {
                const newData = data[0];

                // Mise à jour Ligne
                revenueChart.data.labels = newData.line.labels;
                revenueChart.data.datasets[0].data = newData.line.revenue;
                 revenueChart.data.datasets[1].data = newData.line.maintenance;
                revenueChart.data.datasets[2].data = newData.line.bookings;
                revenueChart.update();

                // Mise à jour Camembert
                clientPieChart.data.labels = newData.pie.labels;
                clientPieChart.data.datasets[0].data = newData.pie.data;
                clientPieChart.update();
            });
        });
    </script>
</div>
