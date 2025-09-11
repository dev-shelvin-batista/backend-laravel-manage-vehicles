<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;

class SettingsController extends Controller
{
    /**
     * Obtain all vehicle configuration data.
     * @return Object List of all vehicle configurations
     */
    public function index(){
        $settings = Settings::all();
        return response()->json($settings, 200);
    }
}
