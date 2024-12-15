<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
   
    public function index(Request $request)
    {
        $notifications = $request->user()->notifications;
        return response()->json($notifications);
    }
}
