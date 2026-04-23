<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonthStart = date('Y-m-01');
        $currentMonthEnd = date('Y-m-t');

        $lastMonthStart = date('Y-m-01', strtotime('-1 month'));
        $lastMonthEnd = date('Y-m-t', strtotime('-1 month'));

        // Crecimiento de Ventas ($) (Flete P) - Mes actual vs Anterior
        $salesCurrentMonth = \App\Models\Sale::whereBetween('fecha', [$currentMonthStart, $currentMonthEnd])->sum('flete_p');
        $salesLastMonth = \App\Models\Sale::whereBetween('fecha', [$lastMonthStart, $lastMonthEnd])->sum('flete_p');

        $salesGrowth = 0;
        if ($salesLastMonth > 0) {
            $salesGrowth = (($salesCurrentMonth - $salesLastMonth) / $salesLastMonth) * 100;
        } elseif ($salesLastMonth == 0 && $salesCurrentMonth > 0) {
            $salesGrowth = 100;
        }

        // Operaciones AWBs
        $awbsCurrentMonth = \App\Models\Sale::whereBetween('fecha', [$currentMonthStart, $currentMonthEnd])->count();
        $awbsLastMonth = \App\Models\Sale::whereBetween('fecha', [$lastMonthStart, $lastMonthEnd])->count();

        $awbsGrowth = 0;
        if ($awbsLastMonth > 0) {
            $awbsGrowth = (($awbsCurrentMonth - $awbsLastMonth) / $awbsLastMonth) * 100;
        } elseif ($awbsLastMonth == 0 && $awbsCurrentMonth > 0) {
            $awbsGrowth = 100;
        }

        // Métricas Universales
        $totalClients = \App\Models\Client::count();
        $totalAgencies = \App\Models\Agency::count();

        // Operaciones Recientes
        $recentSales = \App\Models\Sale::with(['client', 'agency'])
            ->orderBy('fecha', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'salesCurrentMonth',
            'salesGrowth',
            'awbsCurrentMonth',
            'awbsGrowth',
            'totalClients',
            'totalAgencies',
            'recentSales'
        ));
    }
}
