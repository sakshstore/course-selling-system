<?php

namespace App\Http\Controllers;

 

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Support\Facades\File;  

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $activities = ActivityLog::where('user_id', $request->user()->id)->get();
        return response()->json($activities);
    }





} 
