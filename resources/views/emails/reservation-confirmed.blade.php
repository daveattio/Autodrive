<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; background-color: #f3f4f6; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; border-top: 5px solid #2563eb; }
        .header { text-align: center; margin-bottom: 30px; }
        .logo { font-size: 24px; font-weight: bold; color: #1e3a8a; }
        .btn { display: inline-block; background: #2563eb; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .details { background: #f9fafb; padding: 15px; border-radius: 5px; margin: 20px 0; border: 1px solid #e5e7eb; }
        .list-item { margin-bottom: 5px; font-size: 14px; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">Auto<span style="color:#2563eb">Drive</span></div>
        </div>

        <h2>Bonjour {{ $booking->user->name }},</h2>
        <p>Bonne nouvelle ! Votre réservation a été validée par notre équipe.</p>

        <div class="details">
            <div class="list-item"><strong>Véhicule :</strong> {{ $booking->vehicle->brand }} {{ $booking->vehicle->name }}</div>
            <div class="list-item"><strong>Du :</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}</div>
            <div class="list-item"><strong>Au :</strong> {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}</div>
            <div class="list-item"><strong>Total :</strong> {{ number_format($booking->total_price, 0, ',', ' ') }} FCFA</div>
        </div>

        <h3>📋 Documents à fournir le jour J :</h3>
        <ul>
            <li>Votre Permis de conduire original</li>
            <li>Une pièce d'identité (CNI ou Passeport)</li>
            @if($booking->user->client_type == 'entreprise')
                <li>Le bon de commande de la société</li>
            @endif
            <li>La caution (CB ou Espèces)</li>
        </ul>

        <p style="text-align: center;">
            <a href="{{ route('user.bookings') }}" class="btn">Voir ma réservation</a>
        </p>

        <p style="font-size: 12px; color: #999; margin-top: 30px; text-align: center;">
            Merci de votre confiance. L'équipe AutoDrive.
        </p>
    </div>
</body>
</html>
