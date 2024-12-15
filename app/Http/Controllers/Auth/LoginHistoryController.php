<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;


use App\Models\LoginHistory;
use Illuminate\Http\Request;

class LoginHistoryController extends Controller
{
    public function index(Request $request)
    {
        $logins = LoginHistory::where('user_id', $request->user()->id)->orderBy('created_at', 'desc')->get();
        return response()->json($logins);
    }

}
