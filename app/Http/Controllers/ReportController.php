<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Maintenance;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function generate(Request $request)
    {
        // On force le typage entier ici aussi
        $year = (int) $request->input('year', 2026);
        $month = (int) $request->input('month', 1);
        $period = $request->input('period', 'year');

        // 1. DÉFINITION TEMPORELLE IDENTIQUE AU DASHBOARD
        $now = Carbon::now()->setYear($year); // On force l'année sur "Aujourd'hui"

        if ($period == 'month') {
            $now->setMonth($month);
        }

        $title = "";

        if ($period == 'today') {
            $start = $now->copy()->startOfDay();
            $end = $now->copy()->endOfDay();
            $title = "RAPPORT JOURNALIER - " . $start->format('d/m/Y');
        } elseif ($period == 'week') {
            $start = $now->copy()->startOfWeek();
            $end = $now->copy()->endOfWeek();
            $title = "RAPPORT HEBDOMADAIRE (Semaine " . $start->weekOfYear . ")";
        } elseif ($period == 'month') {
            $start = $now->copy()->startOfMonth();
            $end = $now->copy()->endOfMonth();
            $title = "RAPPORT MENSUEL - " . strtoupper($start->translatedFormat('F Y'));
        } else {
            $start = $now->copy()->startOfYear();
            $end = $now->copy()->endOfYear();
            $title = "BILAN ANNUEL $year";
        }

        // 2. KPI (Mêmes requêtes)
        $revenue = Booking::whereBetween('created_at', [$start, $end])
            ->where('payment_status', 'payé')->where('status', '!=', 'annulée')->sum('total_price');

        $bookingsCount = Booking::whereBetween('created_at', [$start, $end])->count();
        $maintenanceCost = Maintenance::whereBetween('start_date', [$start, $end])->sum('cost');
        $netMargin = $revenue - $maintenanceCost;

        // 3. Détails (Tableau)
        $groupBy = ($period == 'year') ? 'MONTH' : 'DATE';
        $details = Booking::select(
            DB::raw("$groupBy(created_at) as date_unit"),
            DB::raw('SUM(total_price) as total'),
            DB::raw('COUNT(*) as count')
        )
            ->whereBetween('created_at', [$start, $end])
            ->where('payment_status', 'payé')->where('status', '!=', 'annulée')
            ->groupBy('date_unit')->orderBy('date_unit')->get();

        // 4. Top Véhicules
        $topVehicles = Booking::select('vehicle_id', DB::raw('count(*) as total'), DB::raw('sum(total_price) as revenue'))
            ->whereBetween('created_at', [$start, $end])->where('status', '!=', 'annulée')
            ->groupBy('vehicle_id')->orderByDesc('revenue')->take(5)->with('vehicle')->get();

        // 5. PDF
        $pdf = Pdf::loadView('admin.pdf.report', compact(
            'title',
            'start',
            'end',
            'revenue',
            'bookingsCount',
            'maintenanceCost',
            'netMargin',
            'details',
            'topVehicles',
            'period',
            'year'
        ));

        return $pdf->stream("Rapport_{$period}_{$year}.pdf");
    }
}
