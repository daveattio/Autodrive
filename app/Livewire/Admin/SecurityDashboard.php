<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\AuditLog;
use Livewire\WithPagination;

class SecurityDashboard extends Component
{
    use WithPagination;

    // Filtres
    public $search = '';
    public $actionFilter = '';
    public $dateStart = '';
    public $dateEnd = '';

    // Reset pagination quand on filtre
    public function updatedSearch() { $this->resetPage(); }
    public function updatedActionFilter() { $this->resetPage(); }
    public function updatedDateStart() { $this->resetPage(); }
    public function updatedDateEnd() { $this->resetPage(); }

    // Nettoyer les filtres
    public function resetFilters()
    {
        $this->reset(['search', 'actionFilter', 'dateStart', 'dateEnd']);
    }

    public function render()
{
    // 1. Requête de base pour la liste filtrée
    $query = AuditLog::with('user')->latest();

    // ... (Tes filtres Search, Action, Date restent ici, ne change rien) ...
    // ... Copie-colle tes conditions if($this->search)... ici ...
    if ($this->search) {
        $query->where(function($q) {
            $q->where('ip_address', 'like', '%'.$this->search.'%')
              ->orWhere('details', 'like', '%'.$this->search.'%')
              ->orWhere('action', 'like', '%'.$this->search.'%')
              ->orWhereHas('user', function($u) {
                  $u->where('name', 'like', '%'.$this->search.'%');
              });
        });
    }
    if ($this->actionFilter) { $query->where('action', $this->actionFilter); }
    if ($this->dateStart) { $query->whereDate('created_at', '>=', $this->dateStart); }
    if ($this->dateEnd) { $query->whereDate('created_at', '<=', $this->dateEnd); }


    // 2. CALCUL DES STATISTIQUES GLOBALES (Pour les cartes du haut)
    // On ne filtre pas ces stats pour avoir une vue d'ensemble
    $stats = [
        'total' => AuditLog::count(),
        'critical' => AuditLog::where('action', 'like', '%ALERTE%')
                              ->orWhere('action', 'like', '%SUPPRESSION%')
                              ->count(),
        'today' => AuditLog::whereDate('created_at', today())->count(),
    ];

    $actionsList = AuditLog::select('action')->distinct()->pluck('action');

    return view('livewire.admin.security-dashboard', [
        'logs' => $query->paginate(15),
        'actionsList' => $actionsList,
        'stats' => $stats // On envoie les stats à la vue
    ]);
}
}
