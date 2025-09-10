<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    /**
   * Obtener los todos datos de los estados de usuarios
   * @return Object Listado de todos los estados de usuarios registrados
   */
  public function index(){
    $status = Status::all();
    return response()->json($status, 200);
  }
}
