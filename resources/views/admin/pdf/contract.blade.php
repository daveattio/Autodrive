<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contrat #{{ $booking->id }}</title>
    <style>
        @page { margin: 0px; }
        body { font-family: 'Helvetica', sans-serif; color: #1f2937; line-height: 1.5; font-size: 12px; margin: 40px; }

        /* En-tête */
        .header { width: 100%; padding-bottom: 20px; border-bottom: 2px solid #2563eb; margin-bottom: 30px; }
        .logo { font-size: 28px; font-weight: 900; color: #111; letter-spacing: -1px; text-transform: uppercase; }
        .logo span { color: #2563eb; }
        .company-details { float: right; text-align: right; font-size: 11px; color: #555; }

        /* Titre */
        .doc-title { text-align: center; margin-bottom: 30px; }
        .doc-title h1 { font-size: 22px; text-transform: uppercase; margin: 0; color: #1f2937; letter-spacing: 1px; }
        .doc-title span { font-size: 12px; color: #6b7280; }

        /* Grille Infos */
        .info-grid { width: 100%; margin-bottom: 20px; }
        .info-box { width: 48%; float: left; border: 1px solid #e5e7eb; padding: 15px; border-radius: 5px; background: #f9fafb; }
        .info-box h3 { margin: 0 0 10px 0; font-size: 14px; border-bottom: 1px solid #ddd; padding-bottom: 5px; color: #2563eb; text-transform: uppercase; }
        .info-row { margin-bottom: 5px; }
        .info-label { font-weight: bold; color: #4b5563; }

        /* Tableau Prix */
        .pricing-table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-bottom: 30px; }
        .pricing-table th { background: #2563eb; color: white; padding: 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
        .pricing-table td { border: 1px solid #e5e7eb; padding: 10px; }
        .total-row td { background: #f3f4f6; font-weight: bold; font-size: 14px; color: #111; border-top: 2px solid #2563eb; }

        /* Conditions Générales (Pour remplir la page) */
        .legal-terms { margin-top: 30px; font-size: 9px; color: #666; text-align: justify; columns: 2; column-gap: 30px; border-top: 1px solid #ddd; padding-top: 20px; }
        .legal-terms h4 { margin: 0 0 5px 0; font-size: 10px; color: #333; }
        .legal-terms p { margin-bottom: 10px; }

        /* Signatures (Collées en bas) */
        .signatures { width: 100%; margin-top: 40px; page-break-inside: avoid; }
        .sig-block { width: 45%; float: left; border: 1px solid #ccc; height: 120px; padding: 10px; border-radius: 5px; }
        .sig-title { font-weight: bold; font-size: 12px; margin-bottom: 40px; display: block; border-bottom: 1px dashed #ccc; padding-bottom: 5px; }

        .footer { position: fixed; bottom: 30px; left: 40px; right: 40px; text-align: center; font-size: 9px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div style="float:left">
            <div class="logo">Auto<span>Drive</span></div>
            <small>Solution de location professionnelle</small>
        </div>
        <div class="company-details">
            <strong>AutoDrive SARL</strong><br>
            123 Avenue de la Libération<br>
            Lomé, Togo<br>
            +228 90 00 00 00 | contact@autodrive.tg
        </div>
        <div style="clear:both"></div>
    </div>

    <div class="doc-title">
        <h1>Contrat de Location</h1>
        <span>Référence : #{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>

    <!-- Info Boxes -->
    <div class="info-grid">
        <div class="info-box">
            <h3>Le Locataire</h3>
            <div class="info-row"><span class="info-label">Nom :</span> {{ $booking->user->name }}</div>
            <div class="info-row"><span class="info-label">Email :</span> {{ $booking->user->email }}</div>
            <div class="info-row"><span class="info-label">Date :</span> {{ now()->format('d/m/Y') }}</div>
        </div>
        <div class="info-box" style="float:right">
            <h3>Le Véhicule</h3>
            <div class="info-row"><span class="info-label">Modèle :</span> {{ $booking->vehicle->brand }} {{ $booking->vehicle->name }}</div>
            <div class="info-row"><span class="info-label">Catégorie :</span> {{ $booking->vehicle->type }}</div>
            <div class="info-row"><span class="info-label">Transmission :</span> {{ $booking->vehicle->transmission }}</div>
        </div>
        <div style="clear:both"></div>
    </div>

    <!-- Pricing -->
    <table class="pricing-table">
        <thead>
            <tr>
                <th width="50%">Désignation</th>
                <th width="15%">Début</th>
                <th width="15%">Fin</th>
                <th width="20%" style="text-align:right">Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    Location de véhicule sans chauffeur<br>
                    <small style="color:#666;">Kilométrage illimité, Assurance standard incluse</small>
                </td>
                <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}</td>
                <td style="text-align:right">{{ number_format($booking->total_price, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align:right;">TOTAL NET À PAYER</td>
                <td style="text-align:right;">{{ number_format($booking->total_price, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tbody>
    </table>

    <div style="text-align:right; font-size:12px; margin-bottom:20px;">
        Statut du paiement :
        <strong style="color: '{{ $booking->payment_status == 'payé' ? 'green' : 'red' }}'">
            {{ strtoupper($booking->payment_status) }}
        </strong>
    </div>

    <!-- Conditions Générales (Pour remplir la page) -->
    <div class="legal-terms">
        <h4>ARTICLE 1 - OBJET DU CONTRAT</h4>
        <p>Le présent contrat a pour objet la location d'un véhicule automobile sans chauffeur. Le locataire reconnaît avoir reçu le véhicule en parfait état de marche et de propreté.</p>

        <h4>ARTICLE 2 - DURÉE ET RESTITUTION</h4>
        <p>La location est consentie pour la durée déterminée au présent contrat. Le véhicule doit être restitué aux date et heure prévues. Tout dépassement de plus de 2 heures entraînera la facturation d'une journée supplémentaire.</p>

        <h4>ARTICLE 3 - ASSURANCES ET RESPONSABILITÉ</h4>
        <p>Le locataire est couvert par une assurance responsabilité civile. Toutefois, il reste responsable des dommages causés au véhicule à hauteur de la franchise en vigueur. Les dégâts causés aux pneumatiques, bris de glace et bas de caisse restent à la charge exclusive du locataire.</p>

        <h4>ARTICLE 4 - OBLIGATIONS DU LOCATAIRE</h4>
        <p>Le locataire s'engage à utiliser le véhicule en bon père de famille, à ne pas transporter de marchandises prohibées, et à ne pas sous-louer le véhicule. Le carburant est à la charge du locataire.</p>

        <h4>ARTICLE 5 - PAIEMENT ET DÉPÔT DE GARANTIE</h4>
        <p>Le paiement de la location est dû à la prise en charge du véhicule. Un dépôt de garantie peut être exigé par carte bancaire. En cas de non-paiement, le loueur se réserve le droit de reprendre le véhicule sans préavis.</p>

        <h4>ARTICLE 6 - LITIGES</h4>
        <p>En cas de litige, les tribunaux de Lomé sont seuls compétents. Le présent contrat est régi par la loi togolaise.</p>
    </div>

    <!-- Signatures -->
    <div class="signatures">
        <div class="sig-block">
            <span class="sig-title">POUR L'AGENCE (Cachet & Signature)</span>
        </div>
        <div class="sig-block" style="float:right">
            <span class="sig-title">LE LOCATAIRE (Lu et approuvé)</span>
        </div>
        <div style="clear:both"></div>
    </div>

    <div class="footer">
        AutoDrive SARL - Capital de 10.000.000 FCFA - RCCM Lomé 2025 - NIF 123456789 - Page 1/1
    </div>

</body>
</html>
