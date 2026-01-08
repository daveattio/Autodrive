<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   protected $fillable = [
    'name',
    'email',
    'password',
    'role',

    // Infos Profil (Phase précédente)
    'client_type',
    'phone',
    'address',
    'city',
    'license_number',
    'passport_number',
    'origin_country',
    'company_name',
    'company_id',

    // --- NOUVEAUX CHAMPS DOCUMENTS (Phase 1) ---
    'license_path',
    'passport_path',
    'company_doc_path',
    'kyc_verified_at',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
   protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',

            // --- NOUVEAU : Pour gérer la date de validation KYC ---
            'kyc_verified_at' => 'datetime',

            // --- CHIFFREMENT DES DONNÉES SENSIBLES (PII) ---
            // Laravel va automatiquement crypter/décrypter ces colonnes
            'license_number'  => 'encrypted',
            'passport_number' => 'encrypted',
            'company_id'      => 'encrypted', // Le NIF est sensible
            'phone'           => 'encrypted', // Le téléphone aussi souvent
            'address'         => 'encrypted', // L'adresse physique aussi
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn($word) => Str::substr($word, 0, 1))
            ->implode('');
    }
    // Vérifie si l'utilisateur a accès au Dashboard (Manager OU Super Admin)
public function isAdmin()
{
    return in_array($this->role, ['admin', 'super_admin']);
}

// Vérifie si l'utilisateur est le Grand Patron
public function isSuperAdmin()
{
    return $this->role === 'super_admin';
}
}
