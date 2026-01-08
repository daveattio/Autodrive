<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsDashboard extends Component
{
    public $period = 'today';

    // KPI
    public $revenue = 0;
    public $bookingsCount = 0;
    public $clientsCount = 0;
    public $vehiclesCount = 0;

    // Listes & Stats
    public $topVehicles = [];

    // Données pour les Graphiques
    public $chartLabels = [];
    public $chartRevenue = [];
    public $chartBookings = [];
    public $chartMaintenance = []; // NOUVEAU

    public $pieLabels = [];
    public $pieData = [];

    public function mount()
    {
        $this->vehiclesCount = Vehicle::count(); // Fixe
        $this->loadData();
    }

    public function updatedPeriod()
    {
        $this->loadData();
        // On envoie TOUTES les données aux graphiques (Ligne + Camembert)
        $this->dispatch('update-charts', [
            'line' => [
                'labels' => $this->chartLabels,
                'revenue' => $this->chartRevenue,
                'bookings' => $this->chartBookings,
                'maintenance' => $this->chartMaintenance, // NOUVEAU
            ],
            'pie' => [
                'labels' => $this->pieLabels,
                'data' => $this->pieData
            ]
        ]);
    }

    public function loadData()
    {
        $startDate = now();
        $endDate = now()->endOfDay();

        // 1. Définition des bornes temporelles
        switch ($this->period) {
            case 'today':
                $startDate = now()->startOfDay();
                break;
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'year':
            default:
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
        }

        // 2. KPI Globaux (Filtrés par date ET par rôle Client)
        $this->revenue = Booking::where('payment_status', 'payé')
            ->where('status', '!=', 'annulée')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('user', function ($q) {       // <--- AJOUTE CECI
                $q->where('role', 'client');        // On exclut les admins
            })
            ->sum('total_price');

        $this->bookingsCount = Booking::whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('user', function ($q) {       // <--- AJOUTE CECI
                $q->where('role', 'client');
            })
            ->count();

        $this->clientsCount = User::where('role', 'client') // C'était déjà bon ici
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // CORRECTION 1 : Parc Auto (Véhicules ajoutés sur la période)
        $this->vehiclesCount = Vehicle::whereBetween('created_at', [$startDate, $endDate])->count();

        // 3. TOP VÉHICULES (Identique)
        $this->topVehicles = Booking::select('vehicle_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->whereHas('user', fn($q) => $q->where('role', 'client')) // Exclure admin
            ->where('status', '!=', 'annulée')
            ->groupBy('vehicle_id')
            ->orderByDesc('total')
            ->take(3)
            ->with('vehicle')
            ->get();

        // 4. DONNÉES GRAPHIQUES (NOUVELLE LOGIQUE "REMPLISSAGE DE TROUS")
        $this->generateChartData($startDate, $endDate);

        // 5. CAMEMBERT (CORRECTION 2 : Clients UNIQUES)
        // On compte les ID distincts pour ne pas compter 2 fois la même entreprise
        $pieStats = Booking::join('users', 'bookings.user_id', '=', 'users.id')
            ->select('users.client_type', DB::raw('count(DISTINCT users.id) as total')) // <--- DISTINCT ICI
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->where('users.role', 'client') // Exclure admin
            ->groupBy('users.client_type')
            ->get();

        $this->pieLabels = [];
        $this->pieData = [];

        foreach ($pieStats as $stat) {
            $this->pieLabels[] = ucfirst($stat->client_type);
            $this->pieData[] = $stat->total;
        }
    }

    // --- NOUVELLE FONCTION INTELLIGENTE ---
    private function generateChartData($start, $end): void
    {
        $this->chartLabels = [];
        $this->chartRevenue = [];
        $this->chartBookings = [];
        $this->chartMaintenance = [];

        // Données brutes filtrées (sans admin, payées pour le revenu)
        $rawData = Booking::whereBetween('created_at', [$start, $end])
            ->whereHas('user', fn($q) => $q->where('role', 'client'))
            ->get();


    // On se base sur la date de début de la maintenance pour l'attribuer au mois/jour
    $maintenances = \App\Models\Maintenance::whereBetween('start_date', [$start, $end])->get();

        if ($this->period == 'today') {
            // Boucle HEURE PAR HEURE (0h à 23h)
            for ($h = 0; $h <= 23; $h++) {
                $this->chartLabels[] = $h . 'h'; // 0h, 1h, 2h...

                // On filtre précisément sur l'heure H
                $hourlyData = $rawData->filter(fn($b) => $b->created_at->hour == $h);
                 $hourlyMaint = $maintenances->filter(fn($m) => $m->start_date->hour == $h);

                $this->chartRevenue[] = $hourlyData->where('payment_status', 'payé')->where('status', '!=', 'annulée')->sum('total_price');
                $this->chartBookings[] = $hourlyData->count();
                 // Pour 'today', c'est peu pertinent d'avoir des maintenances heure par heure, mais on laisse 0 si vide.
            $this->chartMaintenance[] = 0;
            }
        } elseif ($this->period == 'year') {
            for ($m = 1; $m <= 12; $m++) {
                $this->chartLabels[] = Carbon::create(null, $m, 1)->format('M');
                $monthData = $rawData->filter(fn($b) => $b->created_at->month == $m);
                 $monthMaint = $maintenances->filter(fn($maint) => Carbon::parse($maint->start_date)->month == $m);

                $this->chartRevenue[] = $monthData->where('payment_status', 'payé')->where('status', '!=', 'annulée')->sum('total_price');
                $this->chartBookings[] = $monthData->count();
                  $this->chartMaintenance[] = $monthMaint->sum('cost'); // Somme des coûts
            }
        } elseif ($this->period == 'month') {
            $days = now()->daysInMonth;
            for ($d = 1; $d <= $days; $d++) {
                $this->chartLabels[] = $d;
                $dayData = $rawData->filter(fn($b) => $b->created_at->day == $d);
                 $dayMaint = $maintenances->filter(fn($maint) => Carbon::parse($maint->start_date)->day == $d);

                $this->chartRevenue[] = $dayData->where('payment_status', 'payé')->where('status', '!=', 'annulée')->sum('total_price');
                $this->chartBookings[] = $dayData->count();
                  $this->chartMaintenance[] = $dayMaint->sum('cost'); // Somme des coûts
            }
        } elseif ($this->period == 'week') {
            $current = $start->copy();
            for ($i = 0; $i < 7; $i++) {
                $this->chartLabels[] = $current->locale('fr')->isoFormat('ddd');
                $dayData = $rawData->filter(fn($b) => $b->created_at->isSameDay($current));
                 $dayMaint = $maintenances->filter(fn($maint) => Carbon::parse($maint->start_date)->isSameDay($current));

                $this->chartRevenue[] = $dayData->where('payment_status', 'payé')->where('status', '!=', 'annulée')->sum('total_price');
                $this->chartBookings[] = $dayData->count();
                  $this->chartMaintenance[] = $dayMaint->sum('cost');
                $current->addDay();
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.analytics-dashboard');
    }
}
