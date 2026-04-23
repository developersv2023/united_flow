<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AgencyTransaction;
use App\Models\Agency;

class AgencyTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = AgencyTransaction::with('agency');

        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }

        if ($request->filled('awb')) {
            $query->where('awb_referencia', 'like', '%' . $request->awb . '%');
        }

        if ($request->filled('periodo')) {
            $query->where('quincena_periodo', $request->periodo);
        }

        $transactions = $query->orderBy('fecha_transaccion', 'desc')->paginate(15)->withQueryString();
        $agencies = Agency::where('activo', true)->orderBy('nombre')->get();

        return view('agency_transactions.index', compact('transactions', 'agencies'));
    }

    public function create()
    {
        $agencies = Agency::where('activo', true)->orderBy('nombre')->get();
        return view('agency_transactions.create', compact('agencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'quincena_periodo' => 'required|string|max:50',
            'fecha_transaccion' => 'required|date',
            'awb_referencia' => 'nullable|string|max:50',
            'flete_pp' => 'nullable|numeric|min:0',
            'flete_cc' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'due_agent' => 'nullable|numeric|min:0',
            'total_due_airline' => 'nullable|numeric',
            'subtotal' => 'nullable|numeric',
            'comision' => 'nullable|numeric',
            'iva_comision' => 'nullable|numeric',
            'total_pp' => 'nullable|numeric',
            'total_cc' => 'nullable|numeric',
            'cargos_debitos' => 'nullable|numeric',
            'abonos_creditos' => 'nullable|numeric',
            'saldo_acumulado' => 'required|numeric',
        ]);

        AgencyTransaction::create($validated);

        return redirect()->route('agency_transactions.index')->with('success', 'Transacción de agencia creada exitosamente.');
    }

    public function edit(AgencyTransaction $agencyTransaction)
    {
        $agencies = Agency::where('activo', true)->orderBy('nombre')->get();
        return view('agency_transactions.edit', compact('agencyTransaction', 'agencies'));
    }

    public function update(Request $request, AgencyTransaction $agencyTransaction)
    {
        $validated = $request->validate([
            'agency_id' => 'required|exists:agencies,id',
            'quincena_periodo' => 'required|string|max:50',
            'fecha_transaccion' => 'required|date',
            'awb_referencia' => 'nullable|string|max:50',
            'flete_pp' => 'nullable|numeric|min:0',
            'flete_cc' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'due_agent' => 'nullable|numeric|min:0',
            'total_due_airline' => 'nullable|numeric',
            'subtotal' => 'nullable|numeric',
            'comision' => 'nullable|numeric',
            'iva_comision' => 'nullable|numeric',
            'total_pp' => 'nullable|numeric',
            'total_cc' => 'nullable|numeric',
            'cargos_debitos' => 'nullable|numeric',
            'abonos_creditos' => 'nullable|numeric',
            'saldo_acumulado' => 'required|numeric',
        ]);

        $agencyTransaction->update($validated);

        return redirect()->route('agency_transactions.index')->with('success', 'Transacción de agencia actualizada con éxito.');
    }

    public function destroy(AgencyTransaction $agencyTransaction)
    {
        try {
            $agencyTransaction->delete();
            return redirect()->route('agency_transactions.index')->with('success', 'Transacción eliminada correctamente.');
        } catch (\Exception $e) {
            \Log::error("Error deleting agency transaction: " . $e->getMessage());
            return redirect()->route('agency_transactions.index')->with('error', 'Error al eliminar la transacción: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $query = AgencyTransaction::with('agency');

        if ($request->filled('agency_id')) {
            $query->where('agency_id', $request->agency_id);
        }
        if ($request->filled('awb')) {
            $query->where('awb_referencia', 'like', '%' . $request->awb . '%');
        }
        if ($request->filled('periodo')) {
            $query->where('quincena_periodo', $request->periodo);
        }

        $transactions = $query->orderBy('fecha_transaccion', 'desc')->get();
        $filename = 'Transacciones_Agencias_' . date('Y-m-d_H-i-s') . '.csv';

        $handle = fopen('php://temp', 'w+');
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM

        fputcsv($handle, [
            'ID',
            'Agencia',
            'Quincena / Periodo',
            'Fecha',
            'Referencia / AWB',
            'Flete PP',
            'Flete CC',
            'Tax',
            'Due Agent',
            'Due Airline',
            'Subtotal',
            'Comision',
            'IVA Comision',
            'Total PP',
            'Total CC',
            'Cargos / Debitos',
            'Abonos / Creditos',
            'Saldo Acumulado'
        ], ';');

        foreach ($transactions as $t) {
            fputcsv($handle, [
                $t->id,
                $t->agency ? $t->agency->nombre : '-',
                $t->quincena_periodo,
                $t->fecha_transaccion ? $t->fecha_transaccion->format('d/m/Y') : '-',
                $t->awb_referencia,
                $t->flete_pp,
                $t->flete_cc,
                $t->tax,
                $t->due_agent,
                $t->total_due_airline,
                $t->subtotal,
                $t->comision,
                $t->iva_comision,
                $t->total_pp,
                $t->total_cc,
                $t->cargos_debitos,
                $t->abonos_creditos,
                $t->saldo_acumulado
            ], ';');
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return response($csv)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
