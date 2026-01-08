<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Maintenance; // Si tu as gardé le module maintenance
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADMIN (Ton accès)
        User::create([
            'name' => 'David Admin',
            'email' => 'dav@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'client_type' => 'particulier',
            'created_at' => Carbon::create(2026, 1, 1),
        ]);

        // 2. LA FLOTTE (12 Véhicules variés)
        $vehiclesData = [
            ['Toyota', 'Corolla', 'Berline', 'Automatique', 25000],
            ['Hyundai', 'Tucson', 'SUV / 4x4', 'Automatique', 45000],
            ['Peugeot', '308', 'Economique', 'Manuelle', 15000],
            ['Ford', 'Ranger', 'Utilitaire', 'Manuelle', 60000],
            ['Mercedes', 'Classe C', 'Luxe', 'Automatique', 90000],
            ['Kia', 'Sportage', 'SUV / 4x4', 'Automatique', 40000],
            ['Toyota', 'Yaris', 'Economique', 'Manuelle', 12000],
            ['Renault', 'Duster', 'SUV / 4x4', 'Manuelle', 35000],
            ['BMW', 'X5', 'Luxe', 'Automatique', 120000],
            ['Nissan', 'Hardbody', 'Utilitaire', 'Manuelle', 55000],
            ['Suzuki', 'Swift', 'Economique', 'Manuelle', 10000],
            ['Tesla', 'Model 3', 'Luxe', 'Automatique', 150000],
        ];

        $vehicles = [];
        foreach ($vehiclesData as $v) {
            $vehicles[] = Vehicle::create([
                'brand' => $v[0], 'name' => $v[1], 'type' => $v[2],
                'transmission' => $v[3], 'daily_price' => $v[4],
                'description' => "Véhicule en parfait état, révision 2026 effectuée. Climatisation et GPS inclus.",
                'is_available' => true,
                'image' => null,
                'created_at' => Carbon::create(2026, 1, 1),
            ]);
        }

        // 3. LES CLIENTS (50 Profils pour le camembert)
        $users = [];
        for ($i = 0; $i < 50; $i++) {
            $type = fake()->randomElement(['particulier', 'particulier', 'entreprise', 'touriste']); // Plus de particuliers
            $users[] = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => 'client',
                'client_type' => $type,
                'phone' => fake()->phoneNumber(),
                'city' => 'Lomé',
                'address' => fake()->address(),
                'kyc_verified_at' => rand(0, 1) ? Carbon::create(2026, 1, 15) : null,
                'company_name' => $type == 'entreprise' ? fake()->company() : null,
                'origin_country' => $type == 'touriste' ? fake()->country() : null,
                'created_at' => Carbon::create(2026, rand(1, 12), rand(1, 28)),
            ]);
        }

        // 4. LES RÉSERVATIONS (Boucle sur les 12 mois de 2026)

        for ($month = 1; $month <= 12; $month++) {

            // Simulation de saisonnalité : Plus de ventes en Été (7,8) et Décembre (12)
            $bookingCount = rand(10, 15);
            if (in_array($month, [7, 8, 12])) {
                $bookingCount = rand(20, 30); // Pic d'activité
            }

            for ($i = 0; $i < $bookingCount; $i++) {

                $day = rand(1, 28);
                $createdAt = Carbon::create(2026, $month, $day, rand(8, 18), 0, 0);

                // Durée location
                $duration = rand(2, 10);
                $start = (clone $createdAt)->addDays(rand(1, 5));
                $end = (clone $start)->addDays($duration);

                $vehicle = $vehicles[array_rand($vehicles)];
                $user = $users[array_rand($users)];

                // LOGIQUE DE STATUT
                // Mois passés (Jan -> Oct) = Majoritairement Payé/Terminé
                // Mois actuels/futurs (Nov -> Dec) = En attente / Impayé

                $status = 'confirmée';
                $payment = 'payé';

                if ($month >= 11) {
                    // Fin d'année : dossier en cours
                    $r = rand(1, 10);
                    if ($r > 5) { $status = 'en_attente'; $payment = 'impayé'; }
                    elseif ($r > 2) { $status = 'confirmée'; $payment = 'impayé'; } // Validé mais pas payé
                } else {
                    // Passé : quelques annulations
                    if (rand(1, 20) == 1) { $status = 'annulée'; $payment = 'impayé'; }
                }

                Booking::create([
                    'user_id' => $user->id,
                    'vehicle_id' => $vehicle->id,
                    'start_date' => $start,
                    'end_date' => $end,
                    'total_price' => $vehicle->daily_price * $duration,
                    'status' => $status,
                    'payment_status' => $payment,
                    'created_at' => $createdAt, // IMPORTANT pour le graphique
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
