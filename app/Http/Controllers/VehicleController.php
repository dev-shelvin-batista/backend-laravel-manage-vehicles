<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehicles;


class VehicleController extends Controller
{
    /**
     * Registrar en la base de datos la informacion del vehiculo del usuario
     * @param  Request $request Payload con los datos enviados por el usuario
     * @return Object Datos del vehiculo creado
    */
    public function register(Request $request) {
        // Validar que los campos enviados sean correctos
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'car_plate' => 'required|max:64',
            'year' => 'required',
            'setting_id' => 'required',
            'body_car_id' => 'required',
            'photo' => 'required|max:255'
        ]);
    
        // Si hay algun error en un valor enviado se genera una respuesta con error
        if ($validator->fails()) {
            return response()->json($validator->messages(), 401);
        }
        
        $vehicle = new Vehicles;
        // Asignar los valores a las propiedades
        $vehicle->user_id = $request->user_id;
        $vehicle->car_plate = $request->car_plate;
        $vehicle->year = $request->year;
        $vehicle->setting_id = $request->setting_id;
        $vehicle->body_car_id = $request->body_car_id;
        $vehicle->photo = $request->photo;
        // Generar en la base de datos el nuevo registro
        $vehicle->save();

        return response()->json($vehicle, 200);
    }
}
