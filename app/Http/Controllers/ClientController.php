<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\Client::query();

        // Búsqueda por término (nombre o nit)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('nit', 'like', "%{$search}%");
            });
        }

        // Filtro por Estado (Activo/Inactivo)
        if ($request->filled('status')) {
            $query->where('activo', $request->status === 'active' ? 1 : 0);
        }

        // Paginación de 10 en 10
        $clients = $query->orderBy('nombre')->paginate(10)->withQueryString();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150|unique:clients,nombre',
            'nit' => 'nullable|string|max:20',
            'activo' => 'boolean',
        ]);

        \App\Models\Client::create([
            'nombre' => $validated['nombre'],
            'nit' => $validated['nit'] ?? null,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function edit(\App\Models\Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, \App\Models\Client $client)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:150|unique:clients,nombre,' . $client->id,
            'nit' => 'nullable|string|max:20',
            'activo' => 'boolean',
        ]);

        $client->update([
            'nombre' => $validated['nombre'],
            'nit' => $validated['nit'] ?? null,
            'activo' => $request->has('activo'),
        ]);

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(\App\Models\Client $client)
    {
        try {
            $client->delete();
            return redirect()->route('clients.index')->with('success', 'Cliente eliminado correctamente.');
        } catch (\Exception $e) {
            \Log::error("Error deleting client: " . $e->getMessage());
            return redirect()->route('clients.index')->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        }
    }

    public function exportExcel(Request $request)
    {
        $query = \App\Models\Client::query();

        // Aplicamos los mismos filtros que en el Index
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('nit', 'like', "%{$search}%");
            });
        }
        if ($request->filled('status')) {
            $query->where('activo', $request->status === 'active' ? 1 : 0);
        }

        $clients = $query->orderBy('nombre')->get();

        $filename = 'Listado_Clientes_' . date('Y-m-d_H-i-s') . '.csv';

        // Escribimos un archivo virtual en memoria temporal
        $handle = fopen('php://temp', 'w+');

        // Firma UTF-8 BOM
        fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Cabeceras de columnas
        fputcsv($handle, ['ID', 'Razon Social / Nombre', 'NIT', 'Estado Operativo', 'Fecha de Registro'], ';');

        foreach ($clients as $client) {
            fputcsv($handle, [
                $client->id,
                $client->nombre,
                $client->nit ?? '-',
                $client->activo ? 'Activa' : 'Inactiva',
                $client->created_at ? $client->created_at->format('d/m/Y H:i') : ''
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
