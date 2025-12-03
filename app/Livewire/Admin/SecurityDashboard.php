<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\AuditLog;
use Livewire\WithPagination;

class SecurityDashboard extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.admin.security-dashboard', [
            'logs' => AuditLog::with('user')->latest()->paginate(20)
        ]);
    }
}
