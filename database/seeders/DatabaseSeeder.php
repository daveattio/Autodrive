<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. ADMIN
        User::updateOrCreate(['email' => 'dav@gmail.com'], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'client_type' => 'particulier',
            'created_at' => Carbon::create(2025, 1, 1), // Ancien compte
        ]);

        // 2. FLOTTE
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
        ];

        $vehicles = [];
        foreach ($vehiclesData as $v) {
            $vehicles[] = Vehicle::create([
                'brand' => $v[0], 'name' => $v[1], 'type' => $v[2],
                'transmission' => $v[3], 'daily_price' => $v[4],
                'description' => "Véhicule premium.", 'is_available' => true,
                'created_at' => Carbon::create(2025, 1, 1),
            ]);
        }

        // 3. CLIENTS (80 Clients pour la masse)
        $users = [];
        for ($i = 0; $i < 80; $i++) {
            $type = fake()->randomElement(['particulier', 'entreprise', 'touriste']);
            $users[] = User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => 'client',
                'client_type' => $type,
                'phone' => fake()->phoneNumber(),
                'city' => 'Lomé',
                'created_at' => Carbon::create(2025, rand(1, 12), rand(1, 28)), // Inscrits en 2025
                'kyc_verified_at' => rand(0, 1) ? Carbon::now() : null,
            ]);
        }

        // 4. RÉSERVATIONS (2025 et 2026)
        // On génère 300 réservations sur 2025 (N-1)
        $this->generateBookings(2025, 300, $vehicles, $users);

        // On génère 200 réservations sur 2026 (N)
        $this->generateBookings(2026, 200, $vehicles, $users);
    }

    private function generateBookings($year, $count, $vehicles, $users)
    {
        for ($i = 0; $i < $count; $i++) {
            $month = rand(1, 12);
            // Saisonnalité : Boost en Juillet/Décembre
            if (in_array($month, [7, 8, 12]) && rand(0, 1)) continue;

            $createdAt = Carbon::create($year, $month, rand(1, 28), rand(8, 18), 0, 0);
            $duration = rand(2, 10);
            $end = (clone $createdAt)->addDays($duration);

            $vehicle = $vehicles[array_rand($vehicles)];
            $user = $users[array_rand($users)];

            $status = 'confirmée';
            $payment = 'payé';

            // Pour 2026, on met un peu de "en cours"
            if ($year == 2026 && $month >= 11) {
                $status = rand(0, 1) ? 'en_attente' : 'confirmée';
                $payment = $status == 'confirmée' ? 'payé' : 'impayé';
            }

            Booking::create([
                'user_id' => $user->id,
                'vehicle_id' => $vehicle->id,
                'start_date' => $createdAt,
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
