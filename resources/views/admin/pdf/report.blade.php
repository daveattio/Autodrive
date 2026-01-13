<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        /* CONFIGURATION PAGE & MARGES */
        @page {
            margin-top: 90px; /* Espace pour le header fixe */
            margin-bottom: 50px;
            margin-left: 40px;
            margin-right: 40px;
        }
        body { font-family: 'Helvetica', sans-serif; color: #1e293b; font-size: 11px; }

        /* HEADER FIXE (Répétition sur chaque page) */
        header {
            position: fixed;
            top: -70px; /* Remonte dans la marge */
            left: 0; right: 0;
            height: 60px; /* Plus compact */
            background-color: #0f172a;
            color: white;
            padding: 10px 40px;
            line-height: 1.2;
        }

        .logo-text { font-size: 24px; font-weight: 900; text-transform: uppercase; }
        .logo-text span { color: #3b82f6; }
        .header-right { float: right; text-align: right; margin-top: 5px; }
        .report-title { color: #fbbf24; font-weight: bold; font-size: 14px; text-transform: uppercase; }
        .report-meta { font-size: 9px; opacity: 0.8; }

        /* FOOTER FIXE */
        footer {
            position: fixed; bottom: -30px; left: 0; right: 0;
            text-align: center; font-size: 8px; color: #64748b;
            border-top: 1px solid #e2e8f0; padding-top: 10px;
        }
        .page-num:after { content: counter(page); }

        /* KPI */
        .kpi-container { width: 100%; border-spacing: 15px 0; margin-left: -15px; margin-bottom: 30px; }
        .kpi-box {
            background: #fff; border: 1px solid #cbd5e1;
            padding: 12px; border-radius: 4px; text-align: center;
        }
        .kpi-title { font-size: 9px; text-transform: uppercase; font-weight: bold; color: #64748b; margin-bottom: 5px; }
        .kpi-value { font-size: 16px; font-weight: 900; color: #0f172a; }
        .text-red { color: #dc2626; }
        .text-blue { color: #2563eb; }

        /* TABLEAUX */
        h2 { font-size: 12px; text-transform: uppercase; color: #1e40af; border-bottom: 2px solid #e2e8f0; padding-bottom: 5px; margin-top: 20px; margin-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #1e293b; color: white; padding: 8px; text-align: left; font-size: 9px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        /* Ligne Total */
        .total-row td { background: #f1f5f9; font-weight: bold; font-size: 11px; border-top: 2px solid #1e3a8a; color: #0f172a; }

    </style>
</head>
<body>

    <header>
        <div style="float:left;">
            <div class="logo-text">AUTO<span>DRIVE</span></div>
            <div style="font-size:9px;">Rapport de Gestion</div>
        </div>
        <div class="header-right">
            <div class="report-title">{{ $title }}</div>
            <div class="report-meta">Généré le {{ now()->format('d/m/Y H:i') }}</div>
        </div>
    </header>

    <footer>
        AutoDrive S.A. - Rapport Confidentiel - Page <span class="page-num"></span>
    </footer>

    <!-- 1. KPI -->
    <h2>Performance Globale</h2>
    <table class="kpi-container">
        <tr>
            <td><div class="kpi-box"><div class="kpi-title">Chiffre d'Affaires</div><div class="kpi-value">{{ number_format($revenue, 0, ',', ' ') }} F</div></div></td>
            <td><div class="kpi-box"><div class="kpi-title">Réservations</div><div class="kpi-value">{{ $bookingsCount }}</div></div></td>
            <td><div class="kpi-box"><div class="kpi-title">Coût Maintenance</div><div class="kpi-value text-red">{{ number_format($maintenanceCost, 0, ',', ' ') }} F</div></div></td>
            <td><div class="kpi-box" style="border-color:#2563eb; background:#eff6ff;"><div class="kpi-title text-blue">Marge Nette</div><div class="kpi-value text-blue">{{ number_format($netMargin, 0, ',', ' ') }} F</div></div></td>
        </tr>
    </table>

    <!-- 2. DÉTAILS AVEC SOMME -->
    <h2>Détail de l'activité ({{ ucfirst($period) }})</h2>
    <table>
        <thead>
            <tr>
                <th>Période</th>
                <th class="text-right">Réservations</th>
                <th class="text-right">Revenu Brut</th>
                <th class="text-right">Panier Moyen</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $row)
            <tr>
                <td>
                    @if($period == 'year')
                        <!-- Correction BUG DATE : On utilise $year passé par le contrôleur -->
                        {{ \Carbon\Carbon::create($year, $row->date_unit, 1)->translatedFormat('F Y') }}
                    @else
                        {{ \Carbon\Carbon::parse($row->date_unit)->format('d/m/Y') }}
                    @endif
                </td>
                <td class="text-right">{{ $row->count }}</td>
                <td class="text-right font-bold">{{ number_format($row->total, 0, ',', ' ') }} FCFA</td>
                <td class="text-right">{{ $row->count > 0 ? number_format($row->total / $row->count, 0, ',', ' ') : 0 }} FCFA</td>
            </tr>
            @endforeach

            <!-- LIGNE DE SOMME -->
            <tr class="total-row">
                <td>TOTAL GÉNÉRAL</td>
                <td class="text-right">{{ $bookingsCount }}</td>
                <td class="text-right">{{ number_format($revenue, 0, ',', ' ') }} FCFA</td>
                <td class="text-right">{{ $bookingsCount > 0 ? number_format($revenue / $bookingsCount, 0, ',', ' ') : 0 }} FCFA</td>
            </tr>
        </tbody>
    </table>

    <!-- 3. TOP VÉHICULES -->
    <h2>Top 5 Rentabilité</h2>
    <table>
        <thead>
            <tr>
                <th>Véhicule</th>
                <th>Catégorie</th>
                <th class="text-right">Nb Locations</th>
                <th class="text-right">Revenu Généré</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topVehicles as $stat)
            <tr>
                <td class="font-bold">{{ $stat->vehicle->brand }} {{ $stat->vehicle->name }}</td>
                <td>{{ $stat->vehicle->type }}</td>
                <td class="text-right">{{ $stat->total }}</td>
                <td class="text-right font-bold" style="color:#1e40af;">{{ number_format($stat->revenue, 0, ',', ' ') }} FCFA</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
