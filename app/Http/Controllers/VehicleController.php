<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehicles;
use App\Rules\Base64Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class VehicleController extends Controller
{
    /**
     * Record the user's vehicle information in the database.
     * @param  Request $request Payload with data sent by the user
     * @return Object Vehicle data created
    */
    public function register(Request $request) {
        // Validate that the fields submitted are correct.
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'car_plate' => 'required|max:64',
            'year' => 'required',
            'setting_id' => 'required',
            'body_car_id' => 'required',
            'photo' => ['required',new Base64Image],
        ]);
    
        // If there is an error in a sent value, an error response is generated.
        if ($validator->fails()) {
            return response()->json($validator->messages(), 401);
        }
        $user = User::where([['id', '=', $request->user_id]])->first();
        if(!$user){
            return response()->json(['error' => 'User does not exist'], 401);
        }

        $vehicle = new Vehicles;
        // Assign values to properties
        $vehicle->user_id = $request->user_id;
        $vehicle->car_plate = $request->car_plate;
        $vehicle->year = $request->year;
        $vehicle->setting_id = $request->setting_id;
        $vehicle->body_car_id = $request->body_car_id;
        $vehicle->photo = generateImageFile($request->input('photo'));
        // Generate the new record in the database.
        $vehicle->save();

        return response()->json($vehicle, 200);
    }
}
