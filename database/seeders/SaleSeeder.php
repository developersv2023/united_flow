<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        $agencyIds = \App\Models\Agency::pluck('id');
        $clientIds = \App\Models\Client::pluck('id');

        // Create 20 random sales
        for ($i = 0; $i < 20; $i++) {

            // Randomly select agency/client if they exist, or leave null
            $agencyId = $agencyIds->count() > 0 && $faker->boolean(70) ? $faker->randomElement($agencyIds) : null;
            $clientId = $clientIds->count() > 0 && $faker->boolean(70) ? $faker->randomElement($clientIds) : null;

            $peso = $faker->randomFloat(2, 50, 2000);
            $tarifaPub = $faker->randomFloat(4, 1.5, 5.0);
            $tarifaNet = $tarifaPub * $faker->randomFloat(2, 0.7, 0.95); // always slightly less

            $fleteP = round($peso * $tarifaPub, 2);
            $fleteN = round($peso * $tarifaNet, 2);

            $gastosGc = $faker->randomFloat(2, 10, 50);
            $gastosOa = $faker->randomFloat(2, 5, 25);
            $incentivo = $faker->boolean(30) ? $faker->randomFloat(2, 10, 100) : 0;
            $diferencial = $faker->boolean(20) ? $faker->randomFloat(2, 5, 20) : 0;
            $sobreventa = $fleteP - $fleteN > 0 ? ($fleteP - $fleteN) * 0.1 : 0;
            $tarifaAjuste = 0;

            // some basic fictional totals
            $totalPp = $faker->boolean(60) ? $fleteP + $gastosGc + $gastosOa : 0;
            $totalCc = $totalPp == 0 ? $fleteP + $gastosGc + $gastosOa : 0;

            \App\Models\Sale::create([
                'fecha' => $faker->dateTimeBetween('-6 months', 'now'),
                'awb' => '125-' . $faker->unique()->numerify('########'),
                'agency_id' => $agencyId,
                'client_id' => $clientId,
                'peso' => $peso,
                'tarifa_publica' => $tarifaPub,
                'tarifa_neta' => $tarifaNet,
                'flete_p' => $fleteP,
                'flete_n' => $fleteN,
                'gastos_gc' => $gastosGc,
                'gastos_oa' => $gastosOa,
                'incentivo' => $incentivo,
                'diferencial' => $diferencial,
                'sobreventa' => round($sobreventa, 2),
                'tarifa_ajuste' => $tarifaAjuste,
                'total_pp' => $totalPp,
                'total_cc' => $totalCc,
            ]);
        }
    }
}
