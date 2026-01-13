<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Maintenance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsDashboard extends Component
{
    public $period = 'year';
    public $selectedYear;
    public $selectedMonth;

    // KPI
    public $revenue = 0;
    public $revenueGrowth = 0;
    public $bookingsCount = 0;
    public $bookingsGrowth = 0;
    public $clientsCount = 0;
    public $vehiclesCount = 0;

    // Charts
    public $chartCategories = [];
    public $seriesRevenueN = [];
    public $seriesRevenueN1 = [];
    public $seriesMaintenance = [];
    public $seriesBookingsN = [];

    // Pie
    public $pieLabels = [];
    public $pieData = [];
    public $totalClientsPie = 0;

    public $topVehicles = [];

    public function mount()
    {
        $this->selectedYear = 2026; // Année de référence pour la démo
        $this->selectedMonth = (int) date('n');
        $this->loadData();
    }

    public function updatedPeriod() { $this->refresh(); }
    public function updatedSelectedYear() { $this->refresh(); }
    public function updatedSelectedMonth() { $this->refresh(); }

    public function refresh()
    {
        $this->loadData();
        $this->dispatch('update-apex-charts', [
            'categories' => $this->chartCategories,
            'revenueN' => $this->seriesRevenueN,
            'revenueN1' => $this->seriesRevenueN1,
            'maintenance' => $this->seriesMaintenance,
            'bookings' => $this->seriesBookingsN,
            'pieLabels' => $this->pieLabels,
            'pieData' => $this->pieData,
            'totalClients' => $this->totalClientsPie
        ]);
    }

    public function loadData()
    {
       // On force (int) pour transformer "2025" (texte) en 2025 (nombre)
        $year = (int) $this->selectedYear;
        $month = (int) $this->selectedMonth;

        $now = Carbon::now()->setYear($year);

        if ($this->period == 'month') {
            $now->setMonth($month);
        }

        // Calcul des bornes (Start/End)
        $startN = $now->copy();
        $endN = $now->copy();
        $unit = 'day'; // Par défaut

        switch ($this->period) {
            case 'today':
                // Aujourd'hui... mais en 2025 !
                $startN = $now->copy()->startOfDay();
                $endN = $now->copy()->endOfDay();
                $unit = 'hour';
                break;

            case 'week':
                // Cette semaine... mais en 2025 !
                $startN = $now->copy()->startOfWeek();
                $endN = $now->copy()->endOfWeek();
                $unit = 'day';
                break;

            case 'month':
                // Ce mois... mais en 2025 !
                $startN = $now->copy()->startOfMonth();
                $endN = $now->copy()->endOfMonth();
                $unit = 'day';
                break;

            case 'year':
            default:
                $startN = $now->copy()->startOfYear();
                $endN = $now->copy()->endOfYear();
                $unit = 'month';
                break;
        }

        // Période N-1 (Exactement 1 an avant la période calculée)
        $startN1 = $startN->copy()->subYear();
        $endN1 = $endN->copy()->subYear();

        // ---------------------------------------------------------
        // 2. REQUÊTES (Identiques, mais basées sur ces dates justes)
        // ---------------------------------------------------------

        $bookingsN = Booking::whereBetween('created_at', [$startN, $endN])->where('status', '!=', 'annulée')->get();
        $bookingsN1 = Booking::whereBetween('created_at', [$startN1, $endN1])->where('status', '!=', 'annulée')->get();
        $maintenancesN = Maintenance::whereBetween('start_date', [$startN, $endN])->get();

        // KPI
        $this->revenue = $bookingsN->where('payment_status', 'payé')->sum('total_price');
        $revN1 = $bookingsN1->where('payment_status', 'payé')->sum('total_price');
        $this->revenueGrowth = $revN1 > 0 ? (($this->revenue - $revN1) / $revN1) * 100 : 0;

        $this->bookingsCount = $bookingsN->count();
        $bkN1 = $bookingsN1->count();
        $this->bookingsGrowth = $bkN1 > 0 ? (($this->bookingsCount - $bkN1) / $bkN1) * 100 : 0;

        // Clients et Véhicules
        $this->clientsCount = User::where('role', 'client')->whereBetween('created_at', [$startN, $endN])->count();
        $this->vehiclesCount = Vehicle::count(); // Parc total fixe

        // CHART DATA (Boucle Temporelle)
        $this->chartCategories = [];
        $this->seriesRevenueN = [];
        $this->seriesRevenueN1 = [];
        $this->seriesMaintenance = [];
        $this->seriesBookingsN = [];

        $cursor = $startN->copy();
        $cursorN1 = $startN1->copy();

        while ($cursor <= $endN) {
            // Label
            if ($unit == 'month') $this->chartCategories[] = $cursor->format('M');
            elseif ($unit == 'day') $this->chartCategories[] = $cursor->format('d/m');
            else $this->chartCategories[] = $cursor->format('H\h');

            // Data N
            $this->seriesRevenueN[] = $bookingsN->filter(fn($b) => $this->matchDate($b->created_at, $cursor, $unit) && $b->payment_status == 'payé')->sum('total_price');
            $this->seriesBookingsN[] = $bookingsN->filter(fn($b) => $this->matchDate($b->created_at, $cursor, $unit))->count();

            // Data N-1
            $this->seriesRevenueN1[] = $bookingsN1->filter(fn($b) => $this->matchDate($b->created_at, $cursorN1, $unit) && $b->payment_status == 'payé')->sum('total_price');

            // Maintenance N
            // (Note: on compare la start_date de la maintenance avec le curseur)
            $this->seriesMaintenance[] = $maintenancesN->filter(fn($m) => $this->matchDate($m->start_date, $cursor, $unit))->sum('cost');

            // Incrément
            if ($unit == 'month') { $cursor->addMonth(); $cursorN1->addMonth(); }
            elseif ($unit == 'day') { $cursor->addDay(); $cursorN1->addDay(); }
            else { $cursor->addHour(); $cursorN1->addHour(); }
        }

        // PIE & TOP
        $this->generatePieData($startN, $endN);
        $this->topVehicles = Booking::select('vehicle_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$startN, $endN])
            ->where('status', '!=', 'annulée')
            ->groupBy('vehicle_id')
            ->orderByDesc('total')
            ->take(4)->with('vehicle')->get();
    }

    private function matchDate($date, $cursor, $unit) {
        $d = is_string($date) ? Carbon::parse($date) : $date;
        if ($unit == 'month') return $d->month == $cursor->month && $d->year == $cursor->year;
        if ($unit == 'day') return $d->isSameDay($cursor);
        return $d->isSameHour($cursor);
    }

    private function generatePieData($start, $end) {
        $stats = Booking::join('users', 'bookings.user_id', '=', 'users.id')
            ->select('users.client_type', DB::raw('count(DISTINCT users.id) as total'))
            ->whereBetween('bookings.created_at', [$start, $end])
            ->where('users.role', 'client')
            ->groupBy('users.client_type')->get();
        $this->pieLabels = array_values($stats->pluck('client_type')->map(fn($t) => ucfirst($t))->toArray());
        $this->pieData = array_values($stats->pluck('total')->toArray());
        $this->totalClientsPie = array_sum($this->pieData);
    }

    public function dispatchCharts()
    {
        $this->dispatch('update-apex-charts', [
            'categories' => $this->chartCategories,
            'revenueN' => $this->seriesRevenueN,
            'revenueN1' => $this->seriesRevenueN1,
            'maintenance' => $this->seriesMaintenance,
            'bookings' => $this->seriesBookingsN,
            'pieLabels' => $this->pieLabels,
            'pieData' => $this->pieData,
            'totalClients' => $this->totalClientsPie
        ]);
    }

    public function render()
    {
        return view('livewire.admin.analytics-dashboard');
    }
}
