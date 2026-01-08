<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        /* RESET & BASES */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            color: #334155;
            line-height: 1.6;
        }

        /* CONTENEUR PRINCIPAL */
        .email-wrapper {
            width: 100%;
            background-color: #f1f5f9;
            padding: 40px 0;
        }

        .email-content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        /* HEADER */
        .email-header {
            background-color: #1e3a8a; /* Bleu Nuit */
            padding: 30px;
            text-align: center;
        }
        .logo {
            font-size: 24px;
            font-weight: 900;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
        }
        .logo span { color: #60a5fa; }

        /* CORPS */
        .email-body { padding: 40px; }

        h1 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 20px;
        }

        p { margin-bottom: 20px; font-size: 14px; color: #475569; }

        /* RÉCAPITULATIF */
        .summary-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .summary-item {
            margin-bottom: 10px;
            font-size: 13px;
        }
        .summary-item strong { color: #1e293b; display: inline-block; width: 120px; }

        /* DOCUMENTS REQUIS (Cadre Important) */
        .requirements-box {
            border-left: 4px solid #f59e0b; /* Orange sérieux */
            background-color: #fffbeb;
            padding: 20px;
            margin-bottom: 30px;
        }
        .req-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #92400e;
            margin-bottom: 10px;
            display: block;
        }
        .req-list {
            margin: 0;
            padding-left: 20px;
            font-size: 13px;
            color: #78350f;
        }
        .req-list li { margin-bottom: 5px; }

        /* BOUTON (CTA) */
        .btn-container { text-align: center; margin-top: 40px; margin-bottom: 20px; }
        .btn {
            background-color: #2563eb;
            color: #ffffff;
            padding: 14px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            display: inline-block;
        }
        .btn:hover { background-color: #1d4ed8; }

        /* FOOTER */
        .email-footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">

            <!-- Logo -->
            <div class="email-header">
                <a href="{{ url('/') }}" class="logo">Auto<span>Drive</span></a>
            </div>

            <div class="email-body">
                <h1>Réservation Confirmée</h1>

                <p>Bonjour {{ $booking->user->name }},</p>
                <p>Nous avons le plaisir de vous informer que votre réservation a été validée par nos services. Votre véhicule est prêt et vous attend.</p>

                <!-- Récapitulatif -->
                <div class="summary-box">
                    <div class="summary-item">
                        <strong>Véhicule :</strong> {{ $booking->vehicle->brand }} {{ $booking->vehicle->name }}
                    </div>
                    <div class="summary-item">
                        <strong>Date de départ :</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} à 08:00
                    </div>
                    <div class="summary-item">
                        <strong>Date de retour :</strong> {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }} à 18:00
                    </div>
                    <div class="summary-item">
                        <strong>Référence :</strong> #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                <!-- Documents à apporter -->
                <div class="requirements-box">
                    <span class="req-title">Important : Documents originaux à présenter</span>
                    <p style="font-size:12px; margin-bottom:10px; margin-top:0;">Lors de la récupération du véhicule, la présence du conducteur principal est obligatoire muni des éléments suivants :</p>
                    <ul class="req-list">
                        <li>Votre Permis de Conduire (Original valide)</li>
                        <li>Votre Pièce d'Identité (CNI ou Passeport)</li>
                        @if($booking->user->client_type == 'entreprise')
                            <li>Un bon de commande ou cachet de la société</li>
                        @endif
                        <li>La carte bancaire utilisée pour le paiement (si applicable)</li>
                    </ul>
                </div>

                <p>Vous pouvez dès à présent télécharger votre facture acquittée depuis votre espace client.</p>

                <!-- Bouton Facture -->
                <div class="btn-container">
                    <a href="{{ route('user.bookings') }}" class="btn">Accéder à ma Facture</a>
                </div>
            </div>

            <div class="email-footer">
                &copy; {{ date('Y') }} AutoDrive Togo SARL.<br>
                123 Avenue de la Libération, Lomé, Togo.<br>
                Ceci est un message automatique, merci de ne pas y répondre.
            </div>
        </div>
    </div>
</body>
</html>
