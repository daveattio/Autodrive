<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contrat N°{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page {
            margin: 100px 30px 50px 30px; /* Haut, Droite, Bas, Gauche */
        }

        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 11px;
            color: #1e293b;
            line-height: 1.3;
        }

        /* --- HEADER FIXE (Sur toutes les pages) --- */
        header {
            position: fixed;
            top: -80px;
            left: 0px;
            right: 0px;
            height: 70px;
            border-bottom: 2px solid #1e3a8a;
        }

        .header-left { float: left; width: 60%; }
        .header-right { float: right; width: 40%; text-align: right; }

        .logo-text { font-size: 26px; font-weight: 900; color: #1e3a8a; text-transform: uppercase; letter-spacing: -1px; }
        .logo-text span { color: #3b82f6; }
        .agency-info { font-size: 9px; color: #64748b; margin-top: 2px; }

        .ref-box {
            border: 1px solid #1e3a8a;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
            background: #eff6ff;
        }
        .ref-title { font-size: 8px; text-transform: uppercase; color: #1e3a8a; font-weight: bold; }
        .ref-number { font-size: 14px; font-weight: bold; color: #000; }

        /* --- FOOTER FIXE --- */
        footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 30px;
            font-size: 8px;
            text-align: center;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
        }
        .page-num:after { content: counter(page); }

        /* --- CONTENU --- */
        .page-title {
            text-align: center;
            background-color: #f1f5f9;
            color: #1e3a8a;
            font-weight: bold;
            text-transform: uppercase;
            padding: 6px;
            font-size: 14px;
            margin-bottom: 20px;
            border-radius: 4px;
            letter-spacing: 1px;
        }

        /* GRILLES D'INFO */
        table.grid { width: 100%; border-collapse: separate; border-spacing: 15px 0; margin-left: -8px; width: calc(100% + 16px); }
        .box { border: 1px solid #cbd5e1; border-radius: 4px; height: 110px; padding: 10px; }
        .box-title { font-size: 10px; font-weight: bold; color: #1e3a8a; text-transform: uppercase; border-bottom: 1px solid #e2e8f0; padding-bottom: 3px; margin-bottom: 8px; }

        .row { margin-bottom: 4px; }
        .label { font-weight: bold; color: #64748b; width: 70px; display: inline-block; }
        .val { font-weight: 600; color: #000; }

        /* SECTION MANUELLE (CARBURANT & ÉTAT) */
        .manual-section {
            margin-top: 15px;
            border: 1px solid #94a3b8;
            border-radius: 4px;
            padding: 10px;
            background-color: #fff;
        }
        .manual-grid { width: 100%; }
        .check-box { display: inline-block; width: 12px; height: 12px; border: 1px solid #000; margin-right: 5px; vertical-align: middle; }
        .fuel-level { font-size: 10px; color: #333; }

        /* TABLEAU PRIX */
        .price-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .price-table th { background: #1e3a8a; color: white; padding: 8px; text-align: left; font-size: 9px; text-transform: uppercase; }
        .price-table td { padding: 8px; border-bottom: 1px solid #e2e8f0; }
        .total-row td { background: #f8fafc; font-size: 13px; font-weight: bold; color: #1e3a8a; border-top: 2px solid #1e3a8a; }

        /* TAMPON */
        .stamp-container {
            height: 50px;
            position: relative;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .stamp {
            position: absolute;
            right: 10px;
            top: 0;
            border: 3px solid #22c55e;
            color: #22c55e;
            font-size: 20px;
            font-weight: 900;
            padding: 5px 20px;
            border-radius: 6px;
            transform: rotate(-8deg);
            opacity: 0.7;
        }
        .stamp-unpaid { border-color: #ef4444; color: #ef4444; }

        /* SIGNATURES (Bas de page absolu pour Page 1) */
        .signatures-wrapper {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 120px;
        }
        .sig-table { width: 100%; border-collapse: separate; border-spacing: 20px 0; }
        .sig-box {
            border: 1px solid #94a3b8;
            height: 90px;
            background: #fdfdfd;
            position: relative;
        }
        .sig-header {
            background: #f1f5f9;
            color: #475569;
            font-size: 9px;
            font-weight: bold;
            padding: 4px;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
            text-transform: uppercase;
        }
        .sig-bottom {
            position: absolute; bottom: 5px; right: 5px; font-size: 8px; color: #94a3b8;
        }

        /* PAGE 2 */
        .page-break { page-break-after: always; }
        .cgl-content {
            font-size: 9px;
            line-height: 1.4;
            column-count: 2;
            column-gap: 30px;
            text-align: justify;
        }
        .cgl-content h4 { margin: 8px 0 2px; color: #1e3a8a; font-size: 10px; }
        .cgl-content p { margin-bottom: 6px; }

    </style>
</head>
<body>

    <!-- HEADER GLOBAL -->
    <header>
        <div class="header-left">
            <div class="logo-text">AUTO<span>DRIVE</span></div>
            <div class="agency-info">
                123 Avenue de la Libération, Lomé - Togo<br>
                Tél : +228 90 00 00 00 | Email : contact@autodrive.tg
            </div>
        </div>
        <div class="header-right">
            <div class="ref-box">
                <div class="ref-title">CONTRAT RÉF.</div>
                <div class="ref-number">#{{ str_pad($booking->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div style="margin-top:5px; font-size:10px;">Date : {{ now()->format('d/m/Y') }}</div>
        </div>
    </header>

    <!-- FOOTER GLOBAL -->
    <footer>
        AutoDrive Togo SARL - Capital de 10.000.000 FCFA - RCCM TG-LOM-2025-B-1234 - Page <span class="page-num"></span>
    </footer>

    <!-- ==================== PAGE 1 ==================== -->

    <div class="page-title">CONDITIONS PARTICULIÈRES DE LOCATION</div>

    <!-- 1. Infos Automatiques -->
    <table class="grid">
        <tr>
            <td width="50%">
                <div class="box">
                    <div class="box-title">LOCATAIRE</div>
                    <div class="row"><span class="label">Nom :</span><span class="val">{{ $booking->user->name }}</span></div>
                    <div class="row"><span class="label">Tél :</span><span class="val">{{ $booking->user->phone ?? 'N/A' }}</span></div>

                    @if($booking->user->client_type == 'entreprise')
                        <div class="row"><span class="label">Société :</span><span class="val">{{ $booking->user->company_name }}</span></div>
                        <div class="row"><span class="label">NIF :</span><span class="val">{{ $booking->user->company_id }}</span></div>
                    @else
                        <div class="row"><span class="label">Permis :</span><span class="val">{{ $booking->user->license_number ?? 'N/A' }}</span></div>
                    @endif
                    <div class="row"><span class="label">Ville :</span><span class="val">{{ $booking->user->city ?? 'Lomé' }}</span></div>
                </div>
            </td>
            <td width="50%">
                <div class="box">
                    <div class="box-title">VÉHICULE</div>
                    <div class="row"><span class="label">Marque :</span><span class="val" style="color:#2563eb">{{ $booking->vehicle->brand }}</span></div>
                    <div class="row"><span class="label">Modèle :</span><span class="val">{{ $booking->vehicle->name }}</span></div>
                    <div class="row"><span class="label">Type :</span><span class="val">{{ $booking->vehicle->type }}</span></div>
                    <div class="row"><span class="label">Boîte :</span><span class="val">{{ $booking->vehicle->transmission }}</span></div>
                    <div class="row"><span class="label">Immat. :</span><span class="val">TG-_____-________</span></div> <!-- Champ à remplir -->
                </div>
            </td>
        </tr>
    </table>

    <!-- 2. Infos Manuelles (CHECKLIST) -->
    <div class="manual-section">
        <div class="box-title" style="border:none; margin-bottom:5px;">ÉTAT DU VÉHICULE</div>
        <table style="width:100%;">
            <tr>
                <td width="50%">
                    <strong>Carburant Départ :</strong><br>
                    <span class="fuel-level">
                        [  ] 1/4 &nbsp;&nbsp; [  ] 1/2 &nbsp;&nbsp; [ ] 3/4 &nbsp;&nbsp; [  ] PLEIN
                    </span>
                </td>
                <td width="50%">
                    <strong>Propreté / État :</strong><br>
                    <span class="fuel-level">
                        [  ] Intérieur OK &nbsp;&nbsp; [  ] Extérieur OK &nbsp;&nbsp; [  ] Roue de secours
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-top:8px;">
                    <div style="border-bottom:1px solid #ccc; width:100%;">Km Départ : ...................... km</div>
                </td>
            </tr>
        </table>
    </div>

    <!-- 3. Tableau Prix -->
    <table class="price-table">
        <thead>
            <tr>
                <th width="40%">Désignation</th>
                <th width="20%">Départ</th>
                <th width="20%">Retour</th>
                <th width="20%" style="text-align:right">Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Location véhicule sans chauffeur</td>
                <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }} <span style="color:#999">08:00</span></td>
                <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }} <span style="color:#999">18:00</span></td>
                <td style="text-align:right">{{ number_format($booking->total_price, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr class="total-row">
                <td colspan="3" style="text-align:right; padding-right:10px;">TOTAL NET À PAYER</td>
                <td style="text-align:right;">{{ number_format($booking->total_price, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tbody>
    </table>

    <!-- 4. Tampon -->
    <div class="stamp-container">
        @if($booking->payment_status == 'payé')
            <div class="stamp">PAYÉ</div>
        @else
            <div class="stamp stamp-unpaid">IMPAYÉ</div>
        @endif
    </div>

    <!-- 5. Signatures (Collées au Footer de la page 1) -->
    <div class="signatures-wrapper">
        <table class="sig-table">
            <tr>
                <td width="50%">
                    <div class="sig-box">
                        <div class="sig-header">POUR L'AGENCE</div>
                    </div>
                </td>
                <td width="50%">
                    <div class="sig-box">
                        <div class="sig-header">LE LOCATAIRE</div>
                        <div class="sig-bottom">Lu et approuvé</div>
                    </div>
                </td>
            </tr>
        </table>
        <div style="text-align:center; font-size:8px; color:#64748b; margin-top:5px; font-style:italic;">
            Le signataire déclare accepter les conditions générales de location figurant en page suivante.
        </div>
    </div>

    <!-- SAUT DE PAGE -->
    <div class="page-break"></div>

    <!-- ==================== PAGE 2 : CGL ==================== -->

    <div class="page-title">CONDITIONS GÉNÉRALES DE LOCATION</div>

    <div class="cgl-content">
        <h4>ARTICLE 1 - OBJET ET DURÉE</h4>
        <p>Le présent contrat a pour objet la location d'un véhicule sans chauffeur. La location est personnelle et non transmissible. Elle est conclue pour une durée déterminée. Toute prolongation doit être sollicitée 24h à l'avance et validée par le loueur sous peine de poursuites judiciaires.</p>

        <h4>ARTICLE 2 - CONDUCTEUR</h4>
        <p>Le véhicule ne peut être conduit que par le locataire désigné au recto ou les conducteurs agréés par le loueur. Tout conducteur doit être âgé d'au moins 21 ans et titulaire d'un permis de conduire valide depuis plus de 2 ans. En cas de conduite par une personne non autorisée, toutes les assurances sont nulles.</p>

        <h4>ARTICLE 3 - ÉTAT DU VÉHICULE</h4>
        <p>Le véhicule est livré en parfait état de marche et de propreté. Un état des lieux contradictoire est effectué au départ et au retour. Les dommages non signalés au départ seront à la charge du locataire. Le véhicule doit être rendu dans le même état de propreté, faute de quoi des frais de nettoyage seront facturés.</p>

        <h4>ARTICLE 4 - CARBURANT</h4>
        <p>Le carburant est à la charge du locataire. Le véhicule est fourni avec le niveau de carburant indiqué aux conditions particulières (généralement plein) et doit être restitué avec le même niveau. À défaut, le complément sera facturé au prix public majoré de frais de service forfaitaires de 5.000 FCFA.</p>

        <h4>ARTICLE 5 - ENTRETIEN ET PANNES</h4>
        <p>Le locataire doit vérifier régulièrement les niveaux (huile, eau) et la pression des pneus. En cas de panne mécanique non due à une négligence, le loueur assure le dépannage. Les réparations ne peuvent être effectuées qu'après accord écrit du loueur. Les crevaisons sont à la charge exclusive du locataire.</p>

        <h4>ARTICLE 6 - ASSURANCES</h4>
        <p>Le locataire est assuré pour les dommages causés aux tiers (Responsabilité Civile). Une franchise reste à la charge du locataire en cas d'accident responsable ou sans tiers identifié. Le vol n'est couvert que si les clés originales sont restituées au loueur. Les effets personnels ne sont pas couverts.</p>

        <h4>ARTICLE 7 - RESPONSABILITÉ ET INFRACTIONS</h4>
        <p>Le locataire est seul responsable des amendes, contraventions et procès-verbaux établis à son encontre pendant la durée de la location. Le loueur communiquera les coordonnées du conducteur aux autorités compétentes en cas de demande.</p>

        <h4>ARTICLE 8 - DÉPÔT DE GARANTIE</h4>
        <p>Un dépôt de garantie est exigé au départ. Il ne pourra servir au paiement de la location. Il sera restitué en fin de location, déduction faite des éventuels frais de remise en état ou de carburant manquant.</p>

        <h4>ARTICLE 9 - JURIDICTION</h4>
        <p>En cas de litige, les tribunaux du siège social du loueur sont seuls compétents. Le présent contrat est régi par la loi en vigueur au Togo.</p>
    </div>

</body>
</html>
