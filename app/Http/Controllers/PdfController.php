<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generateContract($id)
    {
        // On récupère la réservation avec les infos du client et du véhicule
        $booking = Booking::with(['user', 'vehicle'])->findOrFail($id);

        // On charge la vue PDF
        $pdf = Pdf::loadView('admin.pdf.contract', compact('booking'));

        // On télécharge le fichier
        return $pdf->download('contrat-location-'.$id.'.pdf');
    }
}
