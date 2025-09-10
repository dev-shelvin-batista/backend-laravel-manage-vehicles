<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Vehicles;

class UserController extends Controller
{

    /**
     * Obtener los datos de un solo usuario
     * @param  Request $request Payload con los datos enviados por el usuario
     * @return Object Datos del usuario consultado
     */
    public function index(Request $request){
        // Si hay algun error en un valor enviado se genera una respuesta con error
        if ($request->id == '' || !isset($request->id)) {
            return response()->json(["error" => "The id field is required."], 403);
        }
  
        $users = User::where([
            ['id', '=', $request->id]
        ])->first();

        if(isset($users)) {
            $vehicles = Vehicles::where([
                ['user_id', '=', $request->id]
            ])->get();
            $users->vehicles = $vehicles;
        }   

        return response()->json($users, 200);
    }
    
    /**
     * Iniciar sesion con email y password
     * @param  Request $request Payload con los datos enviados por el usuario
     * @return Object Datos del usuario que inicia sesion
     */
    public function authenticate(Request $request)
    {
      // Validar que los campos enviados sean correctos
      $validator = Validator::make($request->all(), [
        'email' => 'required|max:64',
        'password' => 'required',
      ]);
  
      // Si hay algun error en un valor enviado se genera una respuesta con error
      if ($validator->fails()) {
        return response()->json($validator->messages(), 401);
      }
      // Consultar los datos del usuario
      $credentials = User::where([
        ['email', '=', $request->email],
        ['password', '=', sha1($request->password)]
      ])->first();
  
      // Validar si hubo resultados en la consulta para generar el token jwt
      if($credentials){
        /*try {
          if (! $token = JWTAuth::fromUser($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 400);
          }
        } catch (JWTException $e) {
          return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $credentials->tokenjwt = $token;*/
        return response()->json($credentials, 200);
      }else{
        return response()->json(['error' => 'Error in user or password'], 401);
      }
    }
    /**
     * Registrar en la base de datos la informacion del usuario
     * @param  Request $request Payload con los datos enviados por el usuario
     * @return Object Datos del usuario creado
    */
    public function register(Request $request) {
        // Validar que los campos enviados sean correctos
        $validator = Validator::make($request->all(), [
          'name' => 'required|max:128',
          'last_name' => 'required|max:128',
          'type_documentation' => 'required|max:10',
          'documentation' => 'required|max:64',
          'phone_number' => 'required|max:15',
          'email' => 'required|max:100'
        ]);
    
        // Si hay algun error en un valor enviado se genera una respuesta con error
        if ($validator->fails()) {
            return response()->json($validator->messages(), 401);
        }
        $generate_password =  uniqid();
        $user = new User;
        // Asignar los valores a las propiedades
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->type_documentation = $request->type_documentation;
        $user->documentation = $request->documentation;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->status_id = 1;
        $user->password = sha1($generate_password);
        // Generar en la base de datos el nuevo registro
        $user->save();
        $user->pass = $generate_password;

        return response()->json($user, 200);
    }

    /**
     * Editar todos o parte de los datos un registro en la base de datos
     * @param  Request $request Payload con los datos enviados por el usuario
     * @param  [type]  $id      Id del usuario a modificar
     * @return Object Datos del usuario creado
     */
    public function update(Request $request) {
      // Si hay algun error en un valor enviado se genera una respuesta con error
      if ($request->id == '' || !isset($request->id)) {
          return response()->json(["error" => "The id field is required."], 403);
      }
      // Validar que los campos enviados sean correctos
      $validator = Validator::make($request->all(), [
        'address' => 'required|max:255',
        'password' => 'required|max:200'
      ]);

      // Si hay algun error en un valor enviado se genera una respuesta con error
      if ($validator->fails()) {
          return response()->json($validator->messages(), 401);
      }
      $requestData = $request->all();
      $requestData['status_id'] = 2;
      $requestData['password'] = sha1($requestData['password']);
      $requestData['photo_documentation_a'] = "prueba";
      $requestData['photo_documentation_b'] = "prueba";

      // Ejecutar la accion de actualizar
      User::where('id', '=', $request->id)->update(
          $requestData
      );
      $users = User::where('id', $request->id)->first();
      return response()->json($users, 200);
    }
}
