<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = ['vehicle_id', 'type', 'start_date', 'end_date', 'cost', 'description'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
         'cost' => 'decimal:2', // Pour être sûr que le coût est un chiffre
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}
