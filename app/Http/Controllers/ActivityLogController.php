<?php

namespace App\Http\Controllers;


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



    
public function events()
{
$eventFiles = File::allFiles(app_path('Events'));
$events = [];

foreach ($eventFiles as $file) {
$events[] =   pathinfo($file)['filename'];
}
return response()->json($events);

} 

} 
