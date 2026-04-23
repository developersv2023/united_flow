<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PendingInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\PendingInvoice::query();

        // Búsqueda por término (factura_num)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('factura_num', 'like', "%{$search}%");
        }

        // Filtro por Estado 
        if ($request->filled('status')) {
            $query->where('estado', $request->status);
        }

        // Filtro por Mes
        if ($request->filled('month')) {
            $query->where('mes_facturado', $request->month);
        }

        // Paginación 
        $invoices = $query->orderBy('fecha_emision', 'desc')->paginate(10)->withQueryString();

        // Obtener meses únicos para el filtro
        $months = \App\Models\PendingInvoice::select('mes_facturado')
            ->whereNotNull('mes_facturado')
            ->distinct()
            ->orderBy('mes_facturado', 'desc')
            ->pluck('mes_facturado');

        return view('pending_invoices.index', compact('invoices', 'months'));
    }

    public function create()
    {
        return view('pending_invoices.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'factura_num' => 'required|string|max:50|unique:pending_invoices,factura_num',
            'fecha_emision' => 'nullable|date',
            'mes_facturado' => 'nullable|string|max:50',
            'monto' => 'required|numeric|min:0',
            'dias_vencido' => 'required|integer|min:0',
            'estado' => 'required|in:PENDIENTE,PAGADA,ANULADA,INCOBRABLE',
        ]);

        \App\Models\PendingInvoice::create($validated);

        return redirect()->route('pending_invoices.index')->with('success', 'Factura creada exitosamente.');
    }

    public function edit(\App\Models\PendingInvoice $pending_invoice)
    {
        return view('pending_invoices.edit', compact('pending_invoice'));
    }

    public function update(Request $request, \App\Models\PendingInvoice $pending_invoice)
    {
        $validated = $request->validate([
            'factura_num' => 'required|string|max:50|unique:pending_invoices,factura_num,' . $pending_invoice->id,
            'fecha_emision' => 'nullable|date',
            'mes_facturado' => 'nullable|string|max:50',
            'monto' => 'required|numeric|min:0',
            'dias_vencido' => 'required|integer|min:0',
            'estado' => 'required|in:PENDIENTE,PAGADA,ANULADA,INCOBRABLE',
        ]);

        $pending_invoice->update($validated);

        return redirect()->route('pending_invoices.index')->with('success', 'Factura actualizada exitosamente.');
    }

    public function destroy(\App\Models\PendingInvoice $pending_invoice)
    {
        try {
            $pending_invoice->delete();
            return redirect()->route('pending_invoices.index')->with('success', 'Factura eliminada correctamente.');
        } catch (\Exception $e) {
            \Log::error("Error deleting invoice: " . $e->getMessage());
            return redirect()->route('pending_invoices.index')->with('error', 'Error al eliminar la factura: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $query = \App\Models\PendingInvoice::query();

        // Aplicamos los mismos filtros que en el Index
        if ($request->filled('search')) {
            $query->where('factura_num', 'like', "%{$request->search}%");
        }
        if ($request->filled('status')) {
            $query->where('estado', $request->status);
        }
        if ($request->filled('month')) {
            $query->where('mes_facturado', $request->month);
        }

        $invoices = $query->orderBy('fecha_emision', 'desc')->get();

        $filename = 'Listado_Facturas_' . date('Y-m-d_H-i-s') . '.csv';

        // Escribimos un archivo virtual en memoria temporal
        $handle = fopen('php://temp', 'w+');

        // Firma UTF-8 BOM
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Cabeceras de columnas
        fputcsv($handle, ['ID', 'Num. Factura', 'Fecha Emisión', 'Mes Facturado', 'Monto', 'Días Vencido', 'Estado'], ';');

        foreach ($invoices as $inv) {
            fputcsv($handle, [
                $inv->id,
                $inv->factura_num,
                $inv->fecha_emision ? $inv->fecha_emision->format('d/m/Y') : '-',
                $inv->mes_facturado ?? '-',
                number_format($inv->monto, 2, '.', ''),
                $inv->dias_vencido,
                $inv->estado
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
