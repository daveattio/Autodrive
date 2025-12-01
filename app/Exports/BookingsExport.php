<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $search;
    protected $status;
    protected $payment;

    // 1. On reçoit les filtres depuis le contrôleur
    public function __construct($search, $status, $payment)
    {
        $this->search = $search;
        $this->status = $status;
        $this->payment = $payment;
    }

    /**
    * 2. On construit la requête avec les filtres
    */
    public function collection()
    {
        $query = Booking::with(['user', 'vehicle']);

        // Filtre Recherche (Copie de ta logique Livewire)
        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('user', function($u) {
                    $u->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('vehicle', function($v) {
                    $v->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('brand', 'like', '%'.$this->search.'%');
                })
                ->orWhere('id', 'like', '%'.$this->search.'%');
            });
        }

        // Filtre Statut
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Filtre Paiement
        if ($this->payment) {
            $query->where('payment_status', $this->payment);
        }

        return $query->latest()->get();
    }

    public function map($booking): array
    {
        return [
            $booking->id,
            $booking->created_at->format('d/m/Y'),
            $booking->user->name,
            $booking->user->client_type,
            $booking->vehicle->brand . ' ' . $booking->vehicle->name,
            number_format($booking->vehicle->daily_price, 0, ',', ' '),
            $booking->start_date . ' au ' . $booking->end_date,
            number_format($booking->total_price, 0, ',', ' '),
            $booking->status,
            $booking->payment_status,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date Commande',
            'Client',
            'Type Client',
            'Véhicule',
            'Prix/Jour',
            'Période',
            'Total (FCFA)',
            'Statut',
            'Paiement',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1E3A8A']]], // En-tête bleu, texte blanc
        ];
    }
}
