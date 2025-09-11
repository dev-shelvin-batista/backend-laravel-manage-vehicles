<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BodyCar;

class BodyCarController extends Controller
{
    /**
     * Obtain all data on vehicle bodies.
     * @return Object List of all vehicle body types
     */
    public function index(){
        $body_car = BodyCar::all();
        return response()->json($body_car, 200);
    }
}