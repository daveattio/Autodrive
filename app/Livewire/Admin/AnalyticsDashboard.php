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
    public $period = 'year';

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

        // 2. KPI Globaux (Identique à avant)
        $this->revenue = Booking::where('payment_status', 'payé')
            ->where('status', '!=', 'annulée')
            ->whereBetween('created_at', [$startDate, $endDate])->sum('total_price');

        $this->bookingsCount = Booking::whereBetween('created_at', [$startDate, $endDate])->count();

        $this->clientsCount = User::where('role', 'client')
            ->whereBetween('created_at', [$startDate, $endDate])->count();

        // 3. Top Véhicules (Identique à avant)
        $this->topVehicles = Booking::select('vehicle_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', '!=', 'annulée')
            ->groupBy('vehicle_id')
            ->orderByDesc('total')
            ->take(3)
            ->with('vehicle')
            ->get();

        // 4. DONNÉES GRAPHIQUES (NOUVELLE LOGIQUE "REMPLISSAGE DE TROUS")
        $this->generateChartData($startDate, $endDate);

        // 5. Données Camembert (Identique à avant)
        $pieStats = Booking::join('users', 'bookings.user_id', '=', 'users.id')
            ->select('users.client_type', DB::raw('count(*) as total'))
            ->whereBetween('bookings.created_at', [$startDate, $endDate])
            ->groupBy('users.client_type')
            ->get();

        $this->pieLabels = [];
        $this->pieData = [];
        foreach($pieStats as $stat) {
            $this->pieLabels[] = ucfirst($stat->client_type);
            $this->pieData[] = $stat->total;
        }
    }

    // --- NOUVELLE FONCTION INTELLIGENTE ---
    private function generateChartData($start, $end)
    {
        $this->chartLabels = [];
        $this->chartRevenue = [];
        $this->chartBookings = [];

        // On récupère TOUTES les données brutes sur la période
        $rawData = Booking::whereBetween('created_at', [$start, $end])
            ->where('payment_status', 'payé')
            ->where('status', '!=', 'annulée')
            ->get();

        // On génère la ligne du temps selon le filtre
        if ($this->period == 'year') {
            // Boucle sur les 12 mois
            for ($m = 1; $m <= 12; $m++) {
                $date = Carbon::create(null, $m, 1);
                $this->chartLabels[] = $date->format('M'); // Jan, Feb...

                // On filtre les données pour ce mois précis
                $this->chartRevenue[] = $rawData->filter(fn($b) => $b->created_at->month == $m)->sum('total_price');
                $this->chartBookings[] = $rawData->filter(fn($b) => $b->created_at->month == $m)->count();
            }
        }
        elseif ($this->period == 'month') {
            // Boucle sur chaque jour du mois
            $daysInMonth = now()->daysInMonth;
            for ($d = 1; $d <= $daysInMonth; $d++) {
                $this->chartLabels[] = $d; // 1, 2, 3...

                $this->chartRevenue[] = $rawData->filter(fn($b) => $b->created_at->day == $d)->sum('total_price');
                $this->chartBookings[] = $rawData->filter(fn($b) => $b->created_at->day == $d)->count();
            }
        }
        elseif ($this->period == 'week') {
            // Boucle sur les 7 jours de la semaine
            $current = $start->copy();
            for ($i = 0; $i < 7; $i++) {
                $this->chartLabels[] = $current->locale('fr')->isoFormat('ddd'); // Lun, Mar...

                $this->chartRevenue[] = $rawData->filter(fn($b) => $b->created_at->isSameDay($current))->sum('total_price');
                $this->chartBookings[] = $rawData->filter(fn($b) => $b->created_at->isSameDay($current))->count();

                $current->addDay();
            }
        }
        elseif ($this->period == 'today') {
            // Boucle sur des tranches horaires (toutes les 4h par exemple)
            for ($h = 0; $h <= 23; $h+=4) {
                $this->chartLabels[] = $h.'h';

                // On prend la tranche de 4h
                $this->chartRevenue[] = $rawData->filter(fn($b) => $b->created_at->hour >= $h && $b->created_at->hour < $h+4)->sum('total_price');
                $this->chartBookings[] = $rawData->filter(fn($b) => $b->created_at->hour >= $h && $b->created_at->hour < $h+4)->count();
            }
        }
    }

    public function render()
    {
        return view('livewire.admin.analytics-dashboard');
    }
}
