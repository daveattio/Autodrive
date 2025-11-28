<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Contrat N°{{ $booking->id }}</title>
    <style>
        /* RESET & BASES */
        @page {
            margin: 0px;
        }

        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.3;
        }

        /* HEADER BLEU (Haut de page) */
        .header {
            background-color: #1e3a8a;
            /* Bleu foncé AutoDrive */
            color: white;
            padding: 30px 40px;
            height: 50px;
        }

        /* LOGO TYPOGRAPHIQUE (Zéro Image) */
        .logo {
            font-size: 30px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .logo span {
            color: #60a5fa;
        }

        /* Le "Drive" en bleu clair */
        .sub-logo {
            font-size: 10px;
            opacity: 0.8;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        .contract-info {
            float: right;
            text-align: right;
        }

        .contract-label {
            font-size: 10px;
            opacity: 0.7;
            text-transform: uppercase;
        }

        .contract-value {
            font-size: 16px;
            font-weight: bold;
            color: #fff;
        }

        /* CONTENEUR PRINCIPAL */
        .container {
            padding: 30px 40px;
        }

        /* BOITES CLIENT & VEHICULE */
        table.layout-grid {
            width: 100%;
            margin-top: 20px;
            border-spacing: 0;
            border-collapse: separate;
            border-spacing: 15px 0;
            margin-left: -15px;
            width: calc(100% + 30px);
        }

        .box-header {
            background-color: #f1f5f9;
            /* Gris très clair */
            border-top: 3px solid #1e3a8a;
            padding: 8px 10px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #1e3a8a;
        }

        .box-content {
            border: 1px solid #e2e8f0;
            border-top: none;
            padding: 10px;
            height: 80px;
        }

        .info-row {
            margin-bottom: 5px;
        }

        .info-label {
            font-weight: bold;
            color: #64748b;
            font-size: 10px;
            width: 80px;
            display: inline-block;
        }

        .info-value {
            color: #000;
            font-weight: 600;
        }

        /* TABLEAU DE PRIX */
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        .details-table th {
            background-color: #1e3a8a;
            color: white;
            font-size: 10px;
            text-transform: uppercase;
            text-align: left;
            padding: 10px;
        }

        .details-table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 10px;
        }

        .total-row td {
            background-color: #1e3a8a;
            color: white;
            font-size: 14px;
            font-weight: bold;
            border: none;
        }

        /* TAMPON PAYÉ */
        .stamp {
            position: absolute;
            right: 40px;
            top: 550px;
            border: 3px solid #22c55e;
            /* Vert */
            color: #0f9e3aff;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 10px 30px;
            border-radius: 8px;
            transform: rotate(-15deg);
            opacity: 0.3;
        }

        .stamp-unpaid {
            border-color: #ef4444;
            color: #ef4444;
        }

        /* SIGNATURES (Collées en bas) */
        .bottom-wrapper {
            position: fixed;
            bottom: 40px;
            left: 40px;
            right: 40px;
        }

        .legal-notice {
            font-size: 8px;
            color: #64748b;
            text-align: justify;
            border-top: 1px solid #cbd5e1;
            padding-top: 10px;
            margin-bottom: 20px;
        }

        .sig-table {
            width: 100%;
        }

        .sig-box {
            border: 1px dashed #cbd5e1;
            background-color: #f8fafc;
            height: 80px;
            padding: 10px;
            border-radius: 5px;
        }

        .sig-title {
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            color: #475569;
        }

        .footer {
    position: fixed;
    bottom: 20px;
    left: 0;
    right: 0;
    text-align: center;
    font-size: 8px;
    color: #94a3b8;
    background-color: white; /* Ajoute un fond blanc pour éviter la transparence */
    padding-top: 10px;
}

        /* PAGE 2 */
        .page-break {
            page-break-after: always;
        }

        .terms-columns {
            column-count: 2;
            column-gap: 30px;
            text-align: justify;
            font-size: 10px;
        }

        .terms-columns h4 {
            margin-top: 0;
            margin-bottom: 5px;
            color: #1e3a8a;
            font-size: 11px;
        }

        .terms-columns p {
            margin-bottom: 10px;
        }

        .terms-header {
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 20px;
            color: #1e3a8a;
        }
    </style>
</head>

<body>

    <!-- ==================== PAGE 1 ==================== -->

    <!-- Header Bleu -->
    <div class="header">
        <div style="float:left">
            <div class="logo">AUTO<span>DRIVE</span></div>
            <div class="sub-logo">Location de véhicules Premium</div>
        </div>
        <div class="contract-info">
            <div class="contract-label">Contrat N°</div>
            <div class="contract-value">{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div class="contract-label" style="margin-top:5px;">Date : {{ now()->format('d/m/Y') }}</div>
        </div>
    </div>

    <div class="container">

        <!-- Infos Client & Véhicule (Côte à côte) -->
        <table class="layout-grid">
            <tr>
                <td width="50%">
                    <div class="box-header">
                        @if($booking->user->client_type == 'entreprise')
                        LOCATAIRE (SOCIÉTÉ)
                        @else
                        LOCATAIRE (CLIENT)
                        @endif
                    </div>
                    <div class="box-content">

                        <!-- INFOS COMMUNES -->
                        @if($booking->user->client_type == 'entreprise')
                        <div class="info-row"><span class="info-label">Société :</span> <span class="info-value">{{ $booking->user->company_name }}</span></div>
                        <div class="info-row"><span class="info-label">NIF/RCCM :</span> <span class="info-value">{{ $booking->user->company_id }}</span></div>
                        <div class="info-row"><span class="info-label">Représentant :</span> <span class="info-value">{{ $booking->user->name }}</span></div>
                        @else
                        <div class="info-row"><span class="info-label">Nom :</span> <span class="info-value">{{ $booking->user->name }}</span></div>
                        <!-- Permis ou Passeport -->
                        @if($booking->user->client_type == 'touriste')
                        <div class="info-row"><span class="info-label">Passeport :</span> <span class="info-value">{{ $booking->user->passport_number }} ({{ $booking->user->origin_country }})</span></div>
                        @else
                        <div class="info-row"><span class="info-label">Permis N° :</span> <span class="info-value">{{ $booking->user->license_number }}</span></div>
                        @endif
                        @endif

                        <div class="info-row"><span class="info-label">Tél :</span> <span class="info-value">{{ $booking->user->phone }}</span></div>
                        <div class="info-row"><span class="info-label">Ville :</span> <span class="info-value">{{ $booking->user->city }}</span></div>
                    </div>
                </td>
                <td width="50%">
                    <div class="box-header">Véhicule Loué</div>
                    <div class="box-content">
                        <div class="info-row"><span class="info-label">Modèle :</span> <span class="info-value" style="color:#1e3a8a;">{{ $booking->vehicle->brand }} {{ $booking->vehicle->name }}</span></div>
                        <div class="info-row"><span class="info-label">Catégorie :</span> <span class="info-value">{{ $booking->vehicle->type }}</span></div>
                        <div class="info-row"><span class="info-label">Transm. :</span> <span class="info-value">{{ $booking->vehicle->transmission }}</span></div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Tableau Détails -->
        <div class="box-header" style="margin-top:20px;">Détails de la prestation</div>
        <table class="details-table">
            <thead>
                <tr>
                    <th width="40%">Description</th>
                    <th width="20%">Départ</th>
                    <th width="20%">Retour</th>
                    <th width="20%" style="text-align:right">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>Location courte durée</strong><br>
                        <span style="font-size:9px; color:#666;">Kilométrage illimité, Assurance tous risques</span>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}<br>
                        <small style="color:#999">08:00</small>
                    </td>
                    <td>
                        {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}<br>
                        <small style="color:#999">18:00</small>
                    </td>
                    <td style="text-align:right; font-weight:bold;">{{ number_format($booking->total_price, 0, ',', ' ') }} FCFA</td>
                </tr>
                <tr class="total-row">
                    <td colspan="3" style="text-align:right; text-transform:uppercase;">Net à Payer</td>
                    <td style="text-align:right;">{{ number_format($booking->total_price, 0, ',', ' ') }} FCFA</td>
                </tr>
            </tbody>
        </table>

        <!-- Tampon Automatique -->
        @if($booking->payment_status == 'payé')
        <div class="stamp">PAYÉ</div>
        @else
        <div class="stamp stamp-unpaid">IMPAYÉ</div>
        @endif

        <!-- Bas de page (Signatures) -->
        <div class="bottom-wrapper">
            <div class="legal-notice">
                <strong>Déclaration :</strong> Le locataire reconnaît avoir pris connaissance des conditions générales de location au verso et les accepte sans réserve. Il déclare avoir reçu le véhicule en parfait état de marche, de carrosserie et de propreté, avec le plein de carburant. Le locataire est responsable de toutes les infractions au code de la route commises pendant la durée de la location.
            </div>

            <table class="sig-table">
                <tr>
                    <td width="48%">
                        <div class="sig-box">
                            <div class="sig-title">Pour AutoDrive (Cachet)</div>
                        </div>
                    </td>
                    <td width="4%"></td>
                    <td width="48%">
                        <div class="sig-box">
                            <div class="sig-title">Le Locataire (Signature)</div>
                            <div style="margin-top:40px; font-size:8px; text-align:right; color:#94a3b8;">Lu et approuvé</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

    </div>

    <div class="footer">
        AutoDrive Togo SARL - Capital de 10.000.000 FCFA - RCCM TG-LOM-2025-B-1234 - Siège social : Lomé - Page 1/2
    </div>

    <!-- ==================== PAGE 2 ==================== -->
    <div class="page-break"></div>

    <div class="container" style="padding-top:50px;">
        <div class="terms-header">CONDITIONS GÉNÉRALES DE LOCATION</div>

        <div class="terms-columns">
            <h4>ARTICLE 1 - OBJET ET DURÉE</h4>
            <p>Le présent contrat a pour objet la location d'un véhicule sans chauffeur. La location est consentie pour une durée ferme précisée aux conditions particulières. Toute prolongation doit être autorisée par le loueur sous peine de poursuites judiciaires pour détournement de véhicule.</p>

            <h4>ARTICLE 2 - CONDUCTEUR</h4>
            <p>Le véhicule ne peut être conduit que par le locataire ou les conducteurs agréés par le loueur. Le conducteur doit être âgé d'au moins 21 ans et titulaire d'un permis de conduire valide depuis plus de 2 ans.</p>

            <h4>ARTICLE 3 - ÉTAT DU VÉHICULE</h4>
            <p>Le véhicule est remis en parfait état de marche. Un état des lieux est effectué au départ et au retour. Tout dommage constaté au retour et non présent à l'état des lieux de départ sera facturé au locataire selon le barème en vigueur.</p>

            <h4>ARTICLE 4 - CARBURANT</h4>
            <p>Le véhicule est livré avec le plein de carburant. Il doit être restitué avec le plein. À défaut, le complément sera facturé au locataire majoré de frais de service de 5.000 FCFA.</p>

            <h4>ARTICLE 5 - ENTRETIEN ET PANNES</h4>
            <p>Le locataire doit vérifier régulièrement les niveaux. En cas de panne mécanique non due à une négligence du locataire, le loueur assure le dépannage ou le remplacement du véhicule. Les crevaisons sont à la charge du locataire.</p>

            <h4>ARTICLE 6 - ASSURANCES ET FRANCHISE</h4>
            <p>Le locataire est assuré pour les dommages causés aux tiers. En cas d'accident responsable ou sans tiers identifié, une franchise non rachetable restera à la charge du locataire. Le vol n'est couvert que sur présentation des clés du véhicule.</p>

            <h4>ARTICLE 7 - RESPONSABILITÉ</h4>
            <p>Le locataire est seul responsable des amendes, contraventions et procès-verbaux établis à son encontre pendant la période de location.</p>

            <h4>ARTICLE 8 - DÉPÔT DE GARANTIE</h4>
            <p>Un dépôt de garantie est exigé au départ. Il ne pourra servir au paiement de la location. Il sera restitué en fin de location après déduction des éventuels frais de remise en état.</p>

            <h4>ARTICLE 9 - JURIDICTION</h4>
            <p>En cas de litige, les tribunaux du siège social du loueur sont seuls compétents. Le présent contrat est soumis à la loi en vigueur dans le pays de location.</p>
        </div>
    </div>

    <div class="footer">
        Page 2/2 - Conditions Générales de Location - AutoDrive S.A.
    </div>

</body>

</html>
