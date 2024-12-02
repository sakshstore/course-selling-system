<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoginHistory;

class LoginHistoryController extends Controller
{
public function index(Request $request)
{
$logins = LoginHistory::where('user_id', $request->user()->id)->get();
return response()->json($logins);
}

}