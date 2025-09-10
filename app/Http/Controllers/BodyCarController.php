<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BodyCar;

class BodyCarController extends Controller
{
    /**
     * Obtener los todos datos de las carrocerias de los vehiculos
     * @return Object Listado de todas las carrocerias de los vehiculos
     */
    public function index(){
        $body_car = BodyCar::all();
        return response()->json($body_car, 200);
    }
}