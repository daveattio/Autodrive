<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title',
        'description',
        'discount_percent',
        'start_date',
        'end_date',
        'image',
        'is_active',
        'vehicle_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    public function vehicle()
{
    return $this->belongsTo(Vehicle::class);
}
}
