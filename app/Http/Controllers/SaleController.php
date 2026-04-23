<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Sale::with(['agency', 'client']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('awb', 'like', "%{$search}%");
        }

        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-t'));

        $query->whereBetween('fecha', [$startDate, $endDate]);

        $sales = $query->orderBy('fecha', 'desc')->paginate(10)->withQueryString();

        $agencies = \App\Models\Agency::where('activo', true)->orderBy('nombre')->get();
        $clients = \App\Models\Client::where('activo', true)->orderBy('nombre')->get();

        return view('sales.index', compact('sales', 'agencies', 'clients', 'startDate', 'endDate'));
    }

    public function create()
    {
        $agencies = \App\Models\Agency::where('activo', true)->orderBy('nombre')->get();
        $clients = \App\Models\Client::where('activo', true)->orderBy('nombre')->get();
        return view('sales.create', compact('agencies', 'clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'awb' => 'required|string|max:50|unique:sales,awb',
            'agency_id' => 'nullable|exists:agencies,id',
            'client_id' => 'nullable|exists:clients,id',
            'peso' => 'required|numeric|min:0',
            'tarifa_publica' => 'required|numeric|min:0',
            'tarifa_neta' => 'required|numeric|min:0',
            'flete_p' => 'required|numeric|min:0',
            'flete_n' => 'required|numeric|min:0',
            'gastos_gc' => 'required|numeric|min:0',
            'gastos_oa' => 'required|numeric|min:0',
            'incentivo' => 'nullable|numeric',
            'diferencial' => 'nullable|numeric',
            'sobreventa' => 'nullable|numeric',
            'tarifa_ajuste' => 'nullable|numeric',
            'total_pp' => 'required|numeric',
            'total_cc' => 'required|numeric',
        ]);

        \App\Models\Sale::create($validated);

        return redirect()->route('sales.index')->with('success', 'Venta y registro AWB creados exitosamente.');
    }

    public function edit(\App\Models\Sale $sale)
    {
        $agencies = \App\Models\Agency::where('activo', true)->orderBy('nombre')->get();
        $clients = \App\Models\Client::where('activo', true)->orderBy('nombre')->get();
        return view('sales.edit', compact('sale', 'agencies', 'clients'));
    }

    public function update(Request $request, \App\Models\Sale $sale)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'awb' => 'required|string|max:50|unique:sales,awb,' . $sale->id,
            'agency_id' => 'nullable|exists:agencies,id',
            'client_id' => 'nullable|exists:clients,id',
            'peso' => 'required|numeric|min:0',
            'tarifa_publica' => 'required|numeric|min:0',
            'tarifa_neta' => 'required|numeric|min:0',
            'flete_p' => 'required|numeric|min:0',
            'flete_n' => 'required|numeric|min:0',
            'gastos_gc' => 'required|numeric|min:0',
            'gastos_oa' => 'required|numeric|min:0',
            'incentivo' => 'nullable|numeric',
            'diferencial' => 'nullable|numeric',
            'sobreventa' => 'nullable|numeric',
            'tarifa_ajuste' => 'nullable|numeric',
            'total_pp' => 'required|numeric',
            'total_cc' => 'required|numeric',
        ]);

        $sale->update($validated);

        return redirect()->route('sales.index')->with('success', 'Venta AWB actualizada exitosamente.');
    }

    public function destroy(\App\Models\Sale $sale)
    {
        try {
            $sale->delete();
            return redirect()->route('sales.index')->with('success', 'Registro de venta eliminado correctamente.');
        } catch (\Exception $e) {
            \Log::error("Error deleting sale: " . $e->getMessage());
            return redirect()->route('sales.index')->with('error', 'Error al eliminar la venta: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $query = \App\Models\Sale::with(['agency', 'client']);

        if ($request->filled('search')) {
            $query->where('awb', 'like', "%{$request->search}%");
        }
        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-t'));
        $query->whereBetween('fecha', [$startDate, $endDate]);

        $sales = $query->orderBy('fecha', 'desc')->get();
        $filename = 'Ventas_AWB_' . date('Y-m-d_H-i-s') . '.csv';

        $handle = fopen('php://temp', 'w+');
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM

        fputcsv($handle, [
            'ID',
            'Fecha',
            'AWB',
            'Agencia',
            'Cliente',
            'Peso',
            'Tarifa Pub',
            'Tarifa Neta',
            'Flete P',
            'Flete N',
            'Gastos GC',
            'Gastos OA',
            'Incentivo',
            'Diferencial',
            'Sobreventa',
            'Ajuste',
            'Total PP',
            'Total CC'
        ], ';');

        foreach ($sales as $sale) {
            fputcsv($handle, [
                $sale->id,
                $sale->fecha ? $sale->fecha->format('d/m/Y') : '-',
                $sale->awb,
                $sale->agency ? $sale->agency->nombre : '-',
                $sale->client ? $sale->client->nombre : '-',
                number_format($sale->peso, 2, '.', ''),
                number_format($sale->tarifa_publica, 4, '.', ''),
                number_format($sale->tarifa_neta, 4, '.', ''),
                number_format($sale->flete_p, 2, '.', ''),
                number_format($sale->flete_n, 2, '.', ''),
                number_format($sale->gastos_gc, 2, '.', ''),
                number_format($sale->gastos_oa, 2, '.', ''),
                number_format($sale->incentivo, 2, '.', ''),
                number_format($sale->diferencial, 2, '.', ''),
                number_format($sale->sobreventa, 2, '.', ''),
                number_format($sale->tarifa_ajuste, 2, '.', ''),
                number_format($sale->total_pp, 2, '.', ''),
                number_format($sale->total_cc, 2, '.', '')
            ], ';');
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->make($content, 200, $headers);
    }
}
