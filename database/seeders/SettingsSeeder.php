<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insertar data inicial
        DB::table('settings')->insert(
            array(
                'description' => 'CA'
            )
        );
        DB::table('settings')->insert(
            array(
                'description' => '2'
            )
        );
        DB::table('settings')->insert(
            array(
                'description' => '3'
            )
        );
        DB::table('settings')->insert(
            array(
                'description' => '4'
            )
        );
        DB::table('settings')->insert(
            array(
                'description' => '2S2'
            )
        );
        DB::table('settings')->insert(
            array(
                'description' => '2S3'
            )
        );
        DB::table('settings')->insert(
            array(
                'description' => '3S3'
            )
        );
    }
}
