<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Facture #{{ $invoice_number }}</title>
    <style>
        /* RESET */
        @page {
            margin: 0px;
        }

        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
            color: #334155;
            /* Slate 700 */
            margin: 0;
            padding: 0;
        }

        /* BANDEAU TOP */
        .top-strip {
            height: 8px;
            background-color: #0f172a;
            /* Noir/Bleu très foncé */
            width: 100%;
        }

        .container {
            padding: 40px 50px;
        }

        /* HEADER */
        .header-table {
            width: 100%;
            margin-bottom: 40px;
        }

        .logo-text {
            font-size: 26px;
            font-weight: 900;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: -1px;
        }

        .logo-text span {
            color: #3b82f6;
        }

        /* Bleu électrique */

        .invoice-title {
            text-align: right;
            font-size: 32px;
            font-weight: 100;
            /* Très fin, élégant */
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 2px;
        }

        .invoice-status {
            text-align: right;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            margin-top: 5px;
            color: #22c55e;
            /* Vert par défaut */
        }

        .status-unpaid {
            color: #ef4444;
        }

        /* ADRESSES */
        .addresses-table {
            width: 100%;
            margin-bottom: 50px;
        }

        .from-box {
            width: 45%;
            vertical-align: top;
            line-height: 1.5;
            font-size: 11px;
            color: #64748b;
        }

        .to-box-container {
            width: 45%;
            vertical-align: top;
        }

        .to-box {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 15px 20px;
            border-radius: 0 4px 4px 0;
        }

        .to-title {
            font-size: 9px;
            text-transform: uppercase;
            font-weight: bold;
            color: #94a3b8;
            margin-bottom: 5px;
        }

        .to-name {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 5px;
        }

        .to-details {
            font-size: 11px;
            color: #475569;
            line-height: 1.4;
        }

        /* META DATA (Date, N°) */
        .meta-table {
            width: 100%;
            margin-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 10px;
        }

        .meta-label {
            font-weight: bold;
            color: #0f172a;
            font-size: 11px;
        }

        .meta-val {
            text-align: right;
            color: #475569;
        }

        /* TABLEAU PRINCIPAL */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .items-table th {
            background-color: #0f172a;
            /* En-tête sombre */
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }

        .items-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* TOTAUX */
        .totals-container {
            width: 100%;
            margin-top: 30px;
        }

        .totals-table {
            width: 40%;
            float: right;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 8px 0;
            text-align: right;
        }

        .total-label {
            color: #64748b;
            font-size: 11px;
            padding-right: 20px;
        }

        .total-amount {
            font-weight: bold;
            color: #0f172a;
            font-size: 12px;
        }

        .grand-total-row td {
            border-top: 2px solid #0f172a;
            padding-top: 15px;
            padding-bottom: 15px;
            font-size: 18px;
            color: #3b82f6;
        }

        /* FOOTER */
        .footer {
            position: fixed;
            bottom: 40px;
            left: 50px;
            right: 50px;
            text-align: center;
            font-size: 9px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
        }
    </style>
</head>

<body>

    <!-- Bandeau Décoratif -->
    <div class="top-strip"></div>

    <div class="container">

        <!-- Header : Logo + Titre "FACTURE" -->
        <table class="header-table">
            <tr>
                <td>
                    <div class="logo-text">Auto<span>Drive</span></div>
                </td>
                <td style="text-align: right;">
                    <div class="invoice-title">FACTURE</div>
                    <div class="invoice-status {{ $booking->payment_status != 'payé' ? 'status-unpaid' : '' }}">
                        @if($booking->payment_status == 'payé')
                        ACQUITTÉE LE {{ now()->format('d/m/Y') }}
                        @else
                        NON RÉGLÉE
                        @endif
                    </div>
                </td>
            </tr>
        </table>

        <!-- Infos Émetteur (Nous) vs Client -->
        <table class="addresses-table">
            <tr>
                <td class="from-box">
                    <strong>ÉMETTEUR</strong><br><br>
                    AutoDrive Togo SARL<br>
                    123 Avenue de la Libération<br>
                    Lomé, Togo<br>
                    RCCM: TG-LOM-2025-B-1234<br>
                    NIF: 1000567890<br>
                    contact@autodrive.tg
                </td>
                <td style="width: 10%;"></td> <!-- Espace -->
                <td class="to-box-container">
                    <div class="to-box">
                        <div class="to-title">FACTURÉ À</div>
                        @if($booking->user->client_type == 'entreprise')
                        <div class="to-name">{{ $booking->user->company_name }}</div>
                        <div class="to-details">
                            Attn: {{ $booking->user->name }}<br>
                            NIF: {{ $booking->user->company_id }}<br>
                        </div>
                        @else
                        <div class="to-name">{{ $booking->user->name }}</div>
                        <div class="to-details">
                            Client Particulier<br>
                        </div>
                        @endif
                        <div class="to-details" style="margin-top:5px;">
                            {{ $booking->user->address }}<br>
                            {{ $booking->user->city }}, Togo
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Méta données (Numéro, Date) -->
        <table class="meta-table">
            <tr>
                <td><span class="meta-label">Numéro de facture :</span> <span class="meta-val">{{ $invoice_number }}</span></td>
                <td style="text-align: center;"><span class="meta-label">Date d'émission :</span> <span class="meta-val">{{ now()->format('d/m/Y') }}</span></td>
                <td style="text-align: right;"><span class="meta-label">Référence Résa :</span> <span class="meta-val">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</span></td>
            </tr>
        </table>

        <!-- Tableau des Articles -->
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 50%;">Description</th>
                    <th style="width: 10%; text-align: center;">Qté</th>
                    <th style="width: 20%; text-align: right;">Prix Unit. HT</th>
                    <th style="width: 20%; text-align: right;">Total HT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong style="font-size:13px;">Location : {{ $booking->vehicle->brand }} {{ $booking->vehicle->name }}</strong><br>
                        <span style="font-size:10px; color:#64748b;">
                            Période du {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}
                            au {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                        </span>
                    </td>
                    <td style="text-align: center;">{{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1 }} j</td>
                    <td style="text-align: right;">{{ number_format(($booking->vehicle->daily_price / 1.18), 0, ',', ' ') }}</td>
                    <td style="text-align: right;">{{ number_format($ht, 0, ',', ' ') }}</td>
                </tr>
                <!-- Ligne vide pour aérer si besoin -->
                <tr>
                    <td colspan="4" style="height: 50px;"></td>
                </tr>
            </tbody>
        </table>

        <!-- ZONE TOTAUX & TAMPON -->
        <div class="totals-container" style="position: relative; margin-top: 30px;">

            <!-- LE TAMPON (Positionné par rapport à ce bloc) -->
            <div style="position: absolute; left: 20px; top: 0px;">
                @if($booking->payment_status == 'payé')
                <div style="
                border: 4px solid #22c55e;
                color: #22c55e;
                font-size: 30px;
                font-weight: 900;
                text-transform: uppercase;
                padding: 10px 20px;
                border-radius: 10px;
                transform: rotate(-15deg);
                opacity: 0.4;
                display: inline-block;
            ">
                    ACQUITTÉE
                </div>
                @else
                <div style="
                border: 4px solid #ef4444;
                color: #ef4444;
                font-size: 30px;
                /* ... même style ... */
                padding: 10px 20px;
                border-radius: 10px;
                transform: rotate(-15deg);
                opacity: 0.4;
                display: inline-block;
            ">
                    NON RÉGLÉE
                </div>
                @endif
            </div>

            <!-- LE TABLEAU DES PRIX (Flotte à droite) -->
            <table class="totals-table">
                <tr>
                    <td class="total-label">Total Hors Taxe (HT)</td>
                    <td class="total-amount">{{ number_format($ht, 0, ',', ' ') }}</td>
                </tr>
                <tr>
                    <td class="total-label">TVA (18%)</td>
                    <td class="total-amount">{{ number_format($tva, 0, ',', ' ') }}</td>
                </tr>
                <tr class="grand-total-row">
                    <td class="total-label" style="color:#0f172a; font-size:13px;">NET À PAYER (TTC)</td>
                    <td class="total-amount" style="font-size:18px; color:#3b82f6;">{{ number_format($ttc, 0, ',', ' ') }} FCFA</td>
                </tr>
            </table>
            <div style="clear:both;"></div>
        </div>

    </div>

    <!-- Footer -->
    <div class="footer">
        Merci de votre confiance.<br>
        AutoDrive Togo SARL - Capital de 10.000.000 FCFA - Compte Bancaire : ORABANK TG 1234 5678 9012 - IBAN : TG76...
    </div>

</body>

</html>
