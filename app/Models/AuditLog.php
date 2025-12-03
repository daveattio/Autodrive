<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
