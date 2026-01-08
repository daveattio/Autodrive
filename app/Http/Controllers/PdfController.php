<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;

class PdfController extends Controller
{
    public function generateContract($id)
    {
        $booking = Booking::with(['user', 'vehicle'])->findOrFail($id);

        // --- GÉNÉRATION DU QR CODE (Syntaxe Correcte V6) ---
        $qrContent = "CONTRAT #{$booking->id} | CLIENT: {$booking->user->name} | VEHICULE: {$booking->vehicle->brand} | STATUT: {$booking->status}";

        // 1. On instancie l'objet avec 'new' (c'est ça qui bloquait)
        $qrCode = new QrCode(
            data: $qrContent,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 150,
            margin: 0,
            roundBlockSizeMode: RoundBlockSizeMode::Margin
        );

        // 2. On crée le dessinateur
        $writer = new PngWriter();

        // 3. On génère l'image
        $result = $writer->write($qrCode);

        // 4. On récupère le code en base64 pour le PDF
        $qrCodeImage = $result->getDataUri();

        // --- GÉNÉRATION DU PDF ---
        // Note : j'ai renommé la variable passée à la vue en 'qrCode' pour correspondre à ton template
        $pdf = Pdf::loadView('admin.pdf.contract', [
            'booking' => $booking,
            'qrCode' => $qrCodeImage
        ]);

        return $pdf->stream('contrat-'.$booking->id.'.pdf');
    }
}
