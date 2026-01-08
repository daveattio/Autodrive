<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

class AuditLog extends Model
{
    protected $fillable = [
    'user_id',
    'user_role', // <--- Ajouté
    'action',
    'target',
    'details',
    'ip_address',
    'user_agent'
];

 // 2. Fonction magique pour l'affichage (Accessor)
    // Cela permet d'utiliser $log->formatted_agent dans la vue
    public function getFormattedAgentAttribute()
    {
        if (!$this->user_agent) return 'Inconnu';

        $agent = new Agent();
        $agent->setUserAgent($this->user_agent);

        $browser = $agent->browser();
        $platform = $agent->platform(); // Windows, iOS, etc.

        return ($browser) . ' sur ' . $platform;
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
