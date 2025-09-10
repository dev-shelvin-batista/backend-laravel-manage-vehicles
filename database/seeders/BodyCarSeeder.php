<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BodyCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar data inicial
        DB::table('body_car')->insert(
            array(
                'description' => 'Furgón'
            )
        );
        DB::table('body_car')->insert(
            array(
                'description' => 'Volco'
            )
        );
        DB::table('body_car')->insert(
            array(
                'description' => 'Tanque'
            )
        );
        DB::table('body_car')->insert(
            array(
                'description' => 'Estacas'
            )
        );
        DB::table('body_car')->insert(
            array(
                'description' => 'Porta Contenedor'
            )
        );
    }
}
