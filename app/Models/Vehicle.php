<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    // C'est cette partie qui manquait !
    // Elle dit à Laravel : "J'autorise le remplissage automatique de ces colonnes"
    protected $fillable = [
        'name',
        'brand',
        'type',
        'transmission',
        'daily_price',
        'description',
        'image',
        'is_available'
    ];
    public function promotions()
{
    return $this->hasMany(Promotion::class);
}

// --- AJOUTE CETTE FONCTION ---
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
