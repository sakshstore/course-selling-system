<?php

namespace App\Http\Controllers;

use App\Events\VideoCreated;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    
    public function getLastThreeVideos()
    {
        $videos = Video::orderBy('created_at', 'desc')->take(3)->get();
        return response()->json($videos);
    }

   
    public function get_videos()
    {
        $user = Auth::user();
        $videos = Video::where('user_id', $user->id)->get();

        return response()->json($videos);
    }

   

    public function get_attached_videos()
    {
        $videos = Video::whereNotNull('course_id')->get();
        return response()->json($videos);
    }

    
    public function get_video(Video $video)
    {

        return $video;
    }

 

}
