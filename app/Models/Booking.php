<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    // C'est ça qui manquait probablement : l'autorisation de remplir ces champs
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
       'payment_status',  // impayé, en_attente_validation, payé

    // NOUVEAUX CHAMPS
    'payment_method',
    'transaction_ref',
    'payment_proof_path',
    'paid_at'   // Le chemin de la photo de la preuve
    ];

    // Optionnel : Pour dire que la réservation "appartient" à un véhicule
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    // Optionnel : Pour dire que la réservation "appartient" à un client
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
