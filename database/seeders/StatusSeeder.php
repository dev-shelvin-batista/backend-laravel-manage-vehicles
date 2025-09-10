<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar data inicial
        DB::table('status')->insert(
            array(
              'description' => 'Creado'
            )
        );
        DB::table('status')->insert(
            array(
              'description' => 'Activo'
            )
        );
        DB::table('status')->insert(
            array(
              'description' => 'Inactivo'
            )
        );
    }
}
