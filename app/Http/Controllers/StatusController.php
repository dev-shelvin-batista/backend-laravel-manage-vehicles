<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    /**
   * Get all user status data
   * @return Object List of all statuses of registered users
   */
  public function index(){
    $status = Status::all();
    return response()->json($status, 200);
  }
}
