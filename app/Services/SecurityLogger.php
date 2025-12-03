<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class SecurityLogger
{
   public static function record($action, $target, $details = null)
{
    $user = Auth::user();

    AuditLog::create([
        'user_id'    => $user ? $user->id : null,
        'user_role'  => $user ? $user->role : 'invité', // <--- ON SAUVEGARDE LE RÔLE ICI
        'action'     => $action,
        'target'     => $target,
        'details'    => $details,
        'ip_address' => Request::ip(),
        'user_agent' => Request::userAgent(),
    ]);
}
}
