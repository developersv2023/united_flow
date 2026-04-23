<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Agencias
        $agencies = [
            ['nombre' => 'AGD Cargo', 'codigo' => 'AGD', 'cass' => true, 'activo' => true],
            ['nombre' => 'Aimar', 'codigo' => 'Aimar', 'cass' => true, 'activo' => true],
            ['nombre' => 'Ale Cargo', 'codigo' => 'Ale', 'cass' => false, 'activo' => true],
            ['nombre' => 'Cargo Handling Log', 'codigo' => 'CHL', 'cass' => false, 'activo' => true],
            ['nombre' => 'Consol 807', 'codigo' => 'C807', 'cass' => true, 'activo' => true],
            ['nombre' => 'Continental Link', 'codigo' => 'COLlnk', 'cass' => false, 'activo' => true],
            ['nombre' => 'Crowley', 'codigo' => 'Cro', 'cass' => true, 'activo' => true],
            ['nombre' => 'Dym Group', 'codigo' => 'Dym', 'cass' => true, 'activo' => true],
            ['nombre' => 'EFL', 'codigo' => 'EFL', 'cass' => true, 'activo' => true],
            ['nombre' => 'Hermes', 'codigo' => 'Her', 'cass' => false, 'activo' => true]
        ];

        foreach ($agencies as $agency) {
            DB::table('agencies')->insertOrIgnore(array_merge($agency, [
                'created_at' => $now,
                'updated_at' => $now
            ]));
        }

        // 2. Clientes
        $clients = [
            ['nombre' => 'Bioproductores', 'nit' => '0614-123456-101-1', 'activo' => true],
            ['nombre' => 'B and L', 'nit' => '0614-234567-101-2', 'activo' => true],
            ['nombre' => 'Caribex', 'nit' => null, 'activo' => true],
            ['nombre' => 'Trans Export', 'nit' => '0614-345678-101-3', 'activo' => true],
            ['nombre' => 'Salvaplastic', 'nit' => '0614-456789-101-4', 'activo' => true]
        ];

        foreach ($clients as $client) {
            DB::table('clients')->insertOrIgnore(array_merge($client, [
                'created_at' => $now,
                'updated_at' => $now
            ]));
        }

        // 3. Factura Pendiente DTE Dummy
        DB::table('pending_invoices')->insertOrIgnore([
            'factura_num' => 'DTE-1010',
            'fecha_emision' => '2024-02-01',
            'mes_facturado' => 'February 2024',
            'monto' => 2191.25,
            'dias_vencido' => 356,
            'estado' => 'PENDIENTE',
            'created_at' => $now,
            'updated_at' => $now
        ]);

        $this->command->info('✅ Base de datos inicializada con Catálogos maestos según Reportes de Excel!');
    }
}
