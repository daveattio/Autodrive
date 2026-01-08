<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function download($id)
    {
        // 1. Récupérer la réservation
        $booking = Booking::with(['user', 'vehicle'])->findOrFail($id);

        // 2. Sécurité : Seul le client concerné ou l'admin peut voir la facture
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'super_admin' && Auth::id() !== $booking->user_id) {
            abort(403, 'Accès non autorisé.');
        }

        // 3. Calculs Comptables (TVA 18%)
        $totalTTC = $booking->total_price;
        $tvaRate = 0.18;
        $amountHT = $totalTTC / (1 + $tvaRate);
        $amountTVA = $totalTTC - $amountHT;

        // 4. Génération du PDF
        $pdf = Pdf::loadView('admin.pdf.invoice', [
            'booking' => $booking,
            'ht' => $amountHT,
            'tva' => $amountTVA,
            'ttc' => $totalTTC,
            'invoice_number' => 'FAC-' . now()->format('Y') . '-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT)
        ]);

        return $pdf->stream('Facture_' . $booking->id . '.pdf');
    }
}
