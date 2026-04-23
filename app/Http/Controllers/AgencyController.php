<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AgencyController extends Controller
{
    public function index(Request $request)
    {
        $query = Agency::query();

        // Búsqueda por término (nombre o código)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        // Filtro por Estado (Activo/Inactivo)
        if ($request->filled('status')) {
            $query->where('activo', $request->status === 'active' ? 1 : 0);
        }

        // Filtro por Tipo (CASS/No CASS)
        if ($request->filled('type')) {
            $query->where('cass', $request->type === 'cass' ? 1 : 0);
        }

        // Paginación de 5 en 5 para demostrar la vista (antes era 10)
        $agencies = $query->orderBy('nombre')->paginate(5)->withQueryString();

        return view('agencies.index', compact('agencies'));
    }

    public function create()
    {
        return view('agencies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'codigo' => 'nullable|string|max:50|unique:agencies,codigo',
            'cass' => 'boolean',
            'activo' => 'boolean',
        ]);

        Agency::create([
            'nombre' => $validated['nombre'],
            'codigo' => $validated['codigo'] ?? null,
            'cass' => $request->has('cass'),
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('agencies.index')->with('success', 'Agencia creada exitosamente.');
    }

    public function edit(Agency $agency)
    {
        return view('agencies.edit', compact('agency'));
    }

    public function update(Request $request, Agency $agency)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150',
            'codigo' => 'nullable|string|max:50|unique:agencies,codigo,' . $agency->id,
            'cass' => 'boolean',
            'activo' => 'boolean',
        ]);

        $agency->update([
            'nombre' => $validated['nombre'],
            'codigo' => $validated['codigo'] ?? null,
            'cass' => $request->has('cass'),
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('agencies.index')->with('success', 'Agencia actualizada exitosamente.');
    }

    public function destroy(Agency $agency)
    {
        try {
            $agency->delete();
            return redirect()->route('agencies.index')->with('success', 'Agencia eliminada correctamente.');
        } catch (\Exception $e) {
            \Log::error("Error deleting agency: " . $e->getMessage());
            return redirect()->route('agencies.index')->with('error', 'Error al eliminar la agencia: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $query = Agency::query();

        // Aplicamos los mismos filtros que en el Index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('codigo', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('activo', $request->status === 'active' ? 1 : 0);
        }
        if ($request->filled('type')) {
            $query->where('cass', $request->type === 'cass' ? 1 : 0);
        }

        $agencies = $query->orderBy('nombre')->get();

        $filename = 'Listado_Agencias_' . date('Y-m-d_H-i-s') . '.csv';

        // Escribimos un archivo virtual en memoria temporal
        $handle = fopen('php://temp', 'w+');

        // Firma UTF-8 BOM
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Cabeceras de columnas
        fputcsv($handle, ['ID', 'Razon Social', 'Codigo Ref.', 'Modalidad CASS', 'Estado Operativo', 'Fecha de Registro'], ';');

        foreach ($agencies as $agency) {
            fputcsv($handle, [
                $agency->id,
                $agency->nombre,
                $agency->codigo ?? '-',
                $agency->cass ? 'CASS' : 'NO CASS',
                $agency->activo ? 'Activa' : 'Inactiva',
                $agency->created_at ? $agency->created_at->format('d/m/Y H:i') : ''
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
