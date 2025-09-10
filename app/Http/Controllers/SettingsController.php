<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    /**
     * Obtener los todos datos de las configuraciones de los vehiculos
     * @return Object Listado de todas las configuraciones de los vehiculos
     */
    public function index(){
        $settings = Settings::all();
        return response()->json($settings, 200);
    }
}
