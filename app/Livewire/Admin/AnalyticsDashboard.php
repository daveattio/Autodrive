<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsDashboard extends Component
{
    // Variables pour la vue
    public $totalRevenue;
    public $monthlyRevenue;
    public $pendingCount;
    public $totalBookings; // Nouveau
    public $totalClients;  // Nouveau
    public $totalVehicles; // Nouveau

    public $topVehicles;
    public $clientStats;

    public function mount()
    {
        // 1. Les Chiffres Clés
        $this->totalRevenue = Booking::whereIn('status', ['confirmée', 'terminée'])->sum('total_price');

        $this->monthlyRevenue = Booking::whereIn('status', ['confirmée', 'terminée'])
            ->whereMonth('created_at', now()->month)
            ->sum('total_price');

        $this->pendingCount = Booking::where('status', 'en_attente')->count();

        // Nouveaux calculs
        $this->totalBookings = Booking::count();
        $this->totalClients = User::where('role', 'client')->count();
        $this->totalVehicles = Vehicle::count();

        // 2. Top 3 Véhicules
        $this->topVehicles = Booking::select('vehicle_id', DB::raw('count(*) as total'))
            ->groupBy('vehicle_id')
            ->orderByDesc('total')
            ->take(3)
            ->with('vehicle')
            ->get();

        // 3. Répartition Clients
        if ($this->totalClients > 0) {
            $this->clientStats = [
                'particulier' => (User::where('client_type', 'particulier')->count() / $this->totalClients) * 100,
                'entreprise' => (User::where('client_type', 'entreprise')->count() / $this->totalClients) * 100,
                'touriste' => (User::where('client_type', 'touriste')->count() / $this->totalClients) * 100,
            ];
        } else {
            $this->clientStats = ['particulier' => 0, 'entreprise' => 0, 'touriste' => 0];
        }
    }

    public function render()
    {
        return view('livewire.admin.analytics-dashboard');
    }
}
