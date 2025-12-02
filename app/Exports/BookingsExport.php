<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromQuery; // Changement ici
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $ids;
    protected $filters;

    // On reçoit soit une liste d'IDs (sélection), soit les filtres actuels
    public function __construct($ids = null, $filters = [])
    {
        $this->ids = $ids;
        $this->filters = $filters;
    }

    public function query()
    {
        // 1. Si on a sélectionné des cases manuellement, on exporte juste ça
        if (!empty($this->ids)) {
            return Booking::query()->whereIn('id', $this->ids)->with(['user', 'vehicle']);
        }

        // 2. Sinon, on reprend EXACTEMENT la logique de filtrage du tableau
        $query = Booking::query()->with(['user', 'vehicle']);

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($u) use ($search) {
                    $u->where('name', 'like', '%'.$search.'%')
                      ->orWhere('email', 'like', '%'.$search.'%');
                })
                ->orWhereHas('vehicle', function($v) use ($search) {
                    $v->where('name', 'like', '%'.$search.'%')
                      ->orWhere('brand', 'like', '%'.$search.'%');
                })
                ->orWhere('id', 'like', '%'.$search.'%');
            });
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['payment'])) {
            $query->where('payment_status', $this->filters['payment']);
        }

        // Filtres Dates
        if (!empty($this->filters['date_start'])) {
            $query->whereDate('start_date', '>=', $this->filters['date_start']);
        }
        if (!empty($this->filters['date_end'])) {
            $query->whereDate('end_date', '<=', $this->filters['date_end']);
        }

        return $query->latest();
    }

    public function map($booking): array
    {
        // LOGIQUE "NOTE" AUTOMATIQUE
        $note = '';
        if ($booking->status === 'annulée' && $booking->payment_status === 'payé') {
            $note = 'À REMBOURSER';
        } elseif ($booking->payment_status === 'impayé' && $booking->status === 'confirmée') {
            $note = 'Relance paiement';
        }
        return [
            $booking->id,
            $booking->created_at->format('d/m/Y'),
            $booking->start_date . ' au ' . $booking->end_date,
            $booking->user->name,
            ucfirst($booking->user->client_type),
            $booking->vehicle->brand . ' ' . $booking->vehicle->name,
            $booking->vehicle->daily_price,
            $booking->total_price,
            $booking->status,
            $booking->payment_status,
            $note,
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date Commande',
            'Période',
            'Client',
            'Type',
            'Véhicule',
            'Prix/J',
            'Total(FCFA)',
            'Statut',
            'Paiement',
            'Note',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
