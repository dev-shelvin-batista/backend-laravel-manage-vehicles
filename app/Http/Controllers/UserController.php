<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Vehicles;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Rules\Base64Image;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class UserController extends Controller
{
  /**
   * Get data for a single user
   * @param  Request $request Payload with data sent by the user
   * @return Object User data consulted
   */
  public function index(Request $request){
      // If there is an error in a sent value, an error response is generated.
      if ($request->id == '' || !isset($request->id)) {
          return response()->json(["error" => "The id field is required."], 403);
      }

      // Check that the fields you submitted are correct.
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
   * Log in with your email address and password.
   * @param  Request $request Payload with data sent by the user
   * @return Object User login details
   */
  public function authenticate(Request $request)
  {
    // Validate that the fields submitted are correct.
    $validator = Validator::make($request->all(), [
      'email' => 'required|max:64',
      'password' => 'required',
    ]);

    // If there is an error in a sent value, an error response is generated.
    if ($validator->fails()) {
      return response()->json($validator->messages(), 401);
    }
    // Check that the fields you submitted are correct.
    $credentials = User::where([
      ['email', '=', $request->email],
      ['password', '=', sha1($request->password)]
    ])->first();

    // Validate whether there were results in the query to generate the jwt token.
    if($credentials){
      try {
        if (! $token = JWTAuth::fromUser($credentials)) {
          return response()->json(['error' => 'invalid_credentials'], 400);
        }
      } catch (JWTException $e) {
        return response()->json(['error' => 'could_not_create_token'], 500);
      }
      $credentials->token = $token;
      return response()->json($credentials, 200);
    }else{
      return response()->json(['error' => 'Error in user or password'], 401);
    }
  }
  /**
   * Register user information in the database.
   * @param  Request $request Payload with data sent by the user
   * @return Object User data created
  */
  public function register(Request $request) {
      // Validate that the fields submitted are correct.
      $validator = Validator::make($request->all(), [
        'name' => 'required|max:128',
        'last_name' => 'required|max:128',
        'type_documentation' => 'required|max:10',
        'documentation' => 'required|max:64',
        'phone_number' => 'required|max:15',
        'email' => 'required|max:100'
      ]);
  
      // If there is an error in a sent value, an error response is generated.
      if ($validator->fails()) {
        return response()->json($validator->messages(), 401);
      }
      // $generate_password =  uniqid();
      $generate_password =  "1234";
      Log::info("Password: " . $generate_password);

      // Send email with temporary password
      $mail = new PHPMailer(true); // Enable exceptions
      try {
        //Server settings     
        $mail->SMTPDebug = false;       
        $mail->SMTPAuth = true;     
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME'); // Your Gmail address
        $mail->Password = env('MAIL_PASSWORD'); // Your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // or PHPMailer::ENCRYPTION_SMTPS for port 465
        $mail->Port = env('MAIL_PORT'); // 465 for SSL, 587 for TLS
        $mail->CharSet = 'UTF-8';                              

        $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $mail->addAddress($request->email);
        $mail->isHTML(true);
        $mail->Subject = 'Activate user account';
        $mail->Body = 'The account was created with the following temporary password: <b>' . $generate_password . '</b>. Use it when you log in.';
        
        $mail->send();
        Log::info("Message has been sent");
      } catch (Exception $e) {
        Log::error("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
      }

      $user = new User;
      // Assign values to properties
      $user->name = $request->name;
      $user->last_name = $request->last_name;
      $user->type_documentation = $request->type_documentation;
      $user->documentation = $request->documentation;
      $user->phone_number = $request->phone_number;
      $user->email = $request->email;
      $user->status_id = 1;
      $user->password = sha1($generate_password);
      // Generate the new record in the database.
      $user->save();
      $user->pass = $generate_password;

      return response()->json($user, 200);
  }

  /**
   * Edit all or part of the data in a database record.
   * @param  Request $request Payload with data sent by the user
   * @param  [type]  $id      ID of the user to be modified
   * @return Object Updated user data
   */
  public function update(Request $request) {
    // If there is an error in a sent value, an error response is generated.
    if ($request->id == '' || !isset($request->id)) {
        return response()->json(["error" => "The id field is required."], 403);
    }
    // Validate that the fields submitted are correct.
    $validator = Validator::make($request->all(), [
      'address' => 'required|max:255',
      'old_password' => 'required|max:200',
      'new_password' => 'required|max:200',
      'photo_documentation_a' => ['required',new Base64Image],
      'photo_documentation_b' => ['required',new Base64Image],
    ]);

    // If there is an error in a sent value, an error response is generated.
    if ($validator->fails()) {
      return response()->json($validator->messages(), 401);
    }

    // Obtain user data
    $credentials = User::where([
      ['id', '=', $request->id],
      ['password', '=', sha1($request->old_password)]
    ])->first();

    // Validate whether there were results in the query.
    if(!$credentials) {      
      return response()->json(['error' => 'Error in password'], 401);
    }

    $requestData = $request->all();  
    $photo_documentation_a = generateImageFile($request->input('photo_documentation_a'));  
    $photo_documentation_b = generateImageFile($request->input('photo_documentation_b'));  
    $requestData['status_id'] = 2;
    $requestData['password'] = sha1($requestData['new_password']);
    $requestData['photo_documentation_a'] = $photo_documentation_a;
    $requestData['photo_documentation_b'] = $photo_documentation_b;    

    unset($requestData['old_password']);
    unset($requestData['new_password']);

    // Perform the update action
    User::where('id', '=', $request->id)->update(
      $requestData
    );
    $users = User::where('id', $request->id)->first();
    return response()->json($users, 200);
  }
}
