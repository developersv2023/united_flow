<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-t'));

        // Obtener un sumario totalitario del rango de fechas dado
        $resume = \App\Models\Sale::whereBetween('fecha', [$startDate, $endDate])
            ->selectRaw('
                COUNT(id) as total_awbs,
                SUM(peso) as total_peso,
                SUM(flete_p) as suma_flete_p,
                SUM(flete_n) as suma_flete_n,
                SUM(incentivo) as suma_incentivo,
                SUM(sobreventa) as suma_sobreventa,
                SUM(total_cc) as suma_total_cc,
                SUM(total_pp) as suma_total_pp
            ')->first();

        // Obtener la fila de ventas en ese detalle para la tabla desgloce
        $sales = \App\Models\Sale::with(['agency', 'client'])
            ->whereBetween('fecha', [$startDate, $endDate])
            ->orderBy('fecha', 'desc')
            ->paginate(50)
            ->withQueryString();

        return view('reports.index', compact('resume', 'sales', 'startDate', 'endDate'));
    }
}
