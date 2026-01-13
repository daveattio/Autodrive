<div class="space-y-8 p-2 pb-20">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- 1. HEADER STICKY & GLASSMORPHISM (La Surprise UX) -->
    <!-- Reste collé en haut, fond flou, filtres à droite -->
    <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-200/50 -mx-6 px-8 py-4 flex flex-col md:flex-row justify-between items-center mb-6 transition-all duration-300">
        <div>
            <h2 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                <span class="bg-blue-600 w-2 h-6 rounded-full"></span>
                Tableau de Bord
            </h2>
        </div>

        <div class="flex items-center gap-3">
            <!-- Sélecteur MOIS (Apparaît si filtre = mois) -->
            @if($period == 'month')
                <div class="relative group">
                    <select wire:model.live="selectedMonth" class="appearance-none bg-white border border-gray-200 text-xs font-bold text-slate-700 rounded-xl py-2 pl-4 pr-8 shadow-sm focus:ring-2 focus:ring-blue-500 cursor-pointer hover:border-blue-400 transition">
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                        @endforeach
                    </select>
                    <svg class="w-3 h-3 text-gray-400 absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            @endif

            <!-- Sélecteur ANNÉE -->
            <div class="relative group">
                <select wire:model.live="selectedYear" class="appearance-none bg-white border border-gray-200 text-xs font-bold text-slate-700 rounded-xl py-2 pl-4 pr-8 shadow-sm focus:ring-2 focus:ring-blue-500 cursor-pointer hover:border-blue-400 transition">
                    <option value="2026">2026</option>
                    <option value="2025">2025</option>
                </select>
                <svg class="w-3 h-3 text-gray-400 absolute right-3 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>

            <div class="h-6 w-px bg-gray-300 mx-1"></div>

            <!-- Périodes (Pills) -->
           <div class="bg-slate-100 p-1.5 rounded-xl flex shadow-inner border border-slate-200">
    @foreach(['today' => 'J', 'week' => 'S', 'month' => 'M', 'year' => 'A'] as $val => $label)
        <button wire:click="$set('period', '{{ $val }}')"
                class="w-10 h-8 text-sm font-bold rounded-lg transition-all duration-200 flex items-center justify-center
                       {{ $period === $val
                           ? 'bg-red-600 text-white shadow-md scale-105 ring-2 ring-red-300'
                           : 'bg-white text-gray-600 hover:bg-slate-200 hover:text-slate-800' }}"
                role="tab"
                aria-selected="{{ $period === $val ? 'true' : 'false' }}"
                aria-label="Période {{ strtolower($label) }}">
            {{ $label }}
        </button>
    @endforeach
</div>

            <!-- Export -->
            <a href="{{ route('admin.report', ['period' => $period, 'year' => $selectedYear, 'month' => $selectedMonth ?? null]) }}" target="_blank" class="h-9 w-9 flex items-center justify-center bg-slate-900 text-white rounded-xl hover:bg-slate-700 hover:scale-105 transition shadow-lg shadow-slate-900/20" title="Imprimer Rapport">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            </a>
        </div>
    </div>

    <!-- 2. KPI CARDS (Style "Capsule") -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

        <!-- Revenu -->
        <div class="bg-white p-5 rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider mb-1">Chiffre d'Affaires</p>
                <h3 class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-700">
                    {{ number_format($revenue, 0, ',', ' ') }} <span class="text-xs text-gray-400 font-medium">F</span>
                </h3>
                <span class="inline-flex items-center gap-1 text-[10px] font-bold mt-1 {{ $revenueGrowth >= 0 ? 'text-green-500' : 'text-red-500' }}">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $revenueGrowth >= 0 ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}"></path></svg>
                    {{ number_format(abs($revenueGrowth), 1) }}% vs N-1
                </span>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 shadow-sm group-hover:bg-blue-600 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Réservations -->
        <div class="bg-white p-5 rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider mb-1">Activité</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $bookingsCount }}</h3>
                <p class="text-[10px] text-gray-400">Dossiers</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-orange-500 shadow-sm group-hover:bg-orange-500 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
        </div>

        <!-- Clients -->
        <div class="bg-white p-5 rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider mb-1">Acquisition</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $clientsCount }}</h3>
                <p class="text-[10px] text-gray-400">Nouveaux</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-500 shadow-sm group-hover:bg-purple-500 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>

        <!-- Flotte -->
        <div class="bg-white p-5 rounded-[24px] shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 flex items-center justify-between group hover:-translate-y-1 transition duration-300">
            <div>
                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-wider mb-1">Parc Auto</p>
                <h3 class="text-3xl font-black text-slate-800">{{ $vehiclesCount }}</h3>
                <div class="h-1 w-12 bg-blue-600 rounded-full mt-2"></div>
            </div>
            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 shadow-sm group-hover:bg-slate-800 group-hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </div>

    <!-- 3. GRAPHIQUES -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- A. GRAPHIQUE PRINCIPAL (Area Spline) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-[24px] shadow-sm border border-gray-100" wire:ignore
             x-data="{
                init() {
                    let options = {
                        series: [
                            { name: 'Revenu (N)', type: 'area', data: @js($seriesRevenueN) },
                            { name: 'Revenu (N-1)', type: 'line', data: @js($seriesRevenueN1) },
                            { name: 'Maintenance', type: 'line', data: @js($seriesMaintenance) },
                            { name: 'Réservations', type: 'column', data: @js($seriesBookingsN) }
                        ],
                        chart: { type: 'line', height: 350, toolbar: { show: true, tools: { download: true, selection: false, zoom: true, zoomin: true, zoomout: true, pan: false } }, fontFamily: 'Figtree, sans-serif' },
                        stroke: { width: [3, 2, 2, 0], curve: 'smooth', dashArray: [0, 5, 0, 0] },
                        colors: ['#2563eb', '#9ca3af', '#ef4444', '#f97316'],
                        fill: { type: ['gradient', 'solid', 'solid', 'solid'], gradient: { shadeIntensity: 1, opacityFrom: 0.4, opacityTo: 0.05, stops: [0, 100] } },

                        // CONFIGURATION LÉGENDE & ALIGNEMENT
                        legend: { position: 'top', horizontalAlign: 'left', offsetX: 0, fontSize: '12px', markers: { radius: 12 } },

                        // CONFIGURATION AXES Y (Entiers pour Résas)
                        yaxis: [
                            {
                                seriesName: 'Revenu (N)',
                                labels: { formatter: (val) => { return val >= 1000 ? (val/1000).toFixed(0) + 'k' : val }, style: { colors: '#94a3b8' } },
                                title: { text: 'Finance (FCFA)', style: { color: '#94a3b8', fontSize: '10px' } }
                            },
                            { seriesName: 'Revenu (N-1)', show: false },
                            { seriesName: 'Maintenance', show: false },
                            {
                                seriesName: 'Réservations', opposite: true,
                                labels: {
                                    style: { colors: '#f97316' },
                                    formatter: function (val) { return val.toFixed(0); } // PAS DE DECIMALES
                                },
                                title: { text: 'Volume', style: { color: '#f97316', fontSize: '10px' } },
                                min: 0,
                                forceNiceScale: true // Échelle propre
                            }
                        ],
                        // Design Barres Réservations
                        plotOptions: { bar: { borderRadius: 4, columnWidth: '30%' } },

                        xaxis: { categories: @js($chartCategories), labels: { style: { colors: '#94a3b8', fontSize: '11px' } }, axisBorder: { show: false }, axisTicks: { show: false } },
                        grid: { borderColor: '#f1f5f9', strokeDashArray: 4 },
                        dataLabels: { enabled: false }
                    };

                    let chart = new ApexCharts(this.$refs.chart, options);
                    chart.render();

                    Livewire.on('update-apex-charts', data => {
                        chart.updateOptions({ xaxis: { categories: data[0].categories } });
                        chart.updateSeries([
                            { name: 'Revenu (N)', type: 'area', data: data[0].revenueN },
                            { name: 'Revenu (N-1)', type: 'line', data: data[0].revenueN1 },
                            { name: 'Maintenance', type: 'line', data: data[0].maintenance },
                            { name: 'Réservations', type: 'column', data: data[0].bookings }
                        ]);
                    });
                }
             }"
        >
            <h3 class="font-bold text-slate-800 mb-4 ml-1">Analyse 360°</h3>
            <div x-ref="chart"></div>
        </div>

        <!-- B. CAMEMBERT (Donut Épais) -->
        <div class="lg:col-span-1 bg-white p-6 rounded-[24px] shadow-sm border border-gray-100 flex flex-col justify-center" wire:ignore
             x-data="{
                init() {
                    let options = {
                        series: @js($pieData),
                        labels: @js($pieLabels),
                        chart: { type: 'donut', height: 320, fontFamily: 'Figtree, sans-serif' },
                        colors: ['#3b82f6', '#8b5cf6', '#f97316'],
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '65%', // ANNEAU PLUS ÉPAIS (C'était 75%)
                                    labels: { show: false }
                                }
                            }
                        },
                        dataLabels: { enabled: false },
                        legend: { position: 'bottom', markers: { radius: 12 }, fontSize: '11px', fontWeight: 600, itemMargin: { horizontal: 10 } },
                        stroke: { show: false }
                    };
                    let chart = new ApexCharts(this.$refs.donut, options);
                    chart.render();

                    Livewire.on('update-apex-charts', data => {
                        chart.updateOptions({ labels: data[0].pieLabels });
                        chart.updateSeries(data[0].pieData);
                        document.getElementById('totalClientsDisplay').innerText = data[0].totalClients;
                    });
                }
             }"
        >
            <h3 class="font-bold text-slate-800 mb-2 w-full text-center">Répartition Clients</h3>
            <div class="relative flex justify-center items-center h-full">
                <div x-ref="donut" class="w-full"></div>
                <!-- TOTAL AU CENTRE -->
                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none pb-8">
                    <span class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Total</span>
                    <span id="totalClientsDisplay" class="text-4xl font-black text-slate-800">{{ array_sum($pieData) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. TOP FLOTTE (Liste + Zoom) -->
    <div class="bg-white p-6 rounded-[24px] shadow-sm border border-gray-100">
        <h3 class="font-bold text-slate-800 mb-6 flex items-center gap-2 ml-1">
            <span class="bg-yellow-100 text-yellow-600 w-6 h-6 flex items-center justify-center rounded-full text-xs">★</span>
            Top Performances
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($topVehicles as $index => $stat)
                @if($stat->vehicle)
                <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-blue-200 hover:bg-blue-50/30 transition duration-300 group cursor-default">
                    <div class="text-xl font-black text-gray-200 group-hover:text-blue-200">0{{ $index + 1 }}</div>

                    <!-- Image avec ZOOM -->
                    <div class="w-14 h-12 bg-gray-100 rounded-lg overflow-hidden relative shadow-sm border border-gray-200 group-hover:shadow-md transition">
                        @if($stat->vehicle->image)
                            <img src="{{ asset('storage/'.$stat->vehicle->image) }}" class="w-full h-full object-cover transform group-hover:scale-125 transition duration-500">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-300"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/></svg></div>
                        @endif
                    </div>

                    <div class="flex-grow min-w-0">
                        <h4 class="font-bold text-slate-800 text-xs truncate group-hover:text-blue-600 transition">{{ $stat->vehicle->brand }} {{ $stat->vehicle->name }}</h4>
                        <div class="text-[10px] text-gray-500 font-medium">{{ $stat->total }} Locations</div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
